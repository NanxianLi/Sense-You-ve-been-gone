import requests
import time
from datetime import datetime
from bs4 import BeautifulSoup
import MySQLdb
import emails

refreshing_time = 900 #seconds
error_log = 'error_log.txt'

def alert_type(result, i, avg_std_list, alert):
    try:
        if avg_std_list == []:
            alert = "disconnected"
        elif i[0] == '"true"':
            alert = 'open window'
        elif float(i[1]) < (avg_std_list[result.index(i)][0][0] - 3*avg_std_list[result.index(i)][0][1]):
            alert = 'low temperature'
        elif float(i[1]) >= (avg_std_list[result.index(i)][0][0] + 3*avg_std_list[result.index(i)][0][1]):
            alert = 'high temperature'
        elif float(i[2]) > 70:
            alert = 'high humidity'
    except Exception as e:
        alert = "disconnected"
        print(e)
    return alert

def insert_data(result):
    try:
        alert = "null"
        avg_std_list = []
        for each_device in device_name:
            sql_avg_std = "select AVG(temp), STDDEV(temp) from sensor_data where device_name = '%s' and time > NOW()-10000;"%(each_device)
            curs.execute(sql_avg_std)
            avg_std = curs.fetchall()
            db.commit()
            if avg_std == ():
                break
            avg_std_list.append(avg_std)

        for i in result:
            alert = alert_type(result, i, avg_std_list, alert)
            sensor_name = device_name[result.index(i)]
            if alert != 'null':
                alert_info_sql = "select users.email from users, belonging where users.user_id=belonging.user_id and device_name='a7f_window';"
                curs.execute(alert_info_sql)
                email_result = curs.fetchall()
                                                                             
                db.commit()
                alert_content = "Hi, there is a %s from your sensor %s! Please go check!"%(alert, sensor_name)
#                emails.send_email(email_result[0][0],alert_content)

            sql_insert_data = ("""INSERT INTO sensor_data values('%s', NOW(),'%s', %s, %s, %s, %s, '%s')"""\
                          %(device_id[result.index(i)],device_name[result.index(i)],i[0],i[1],i[2],i[3],alert))

            curs.execute(sql_insert_data)
            db.commit()

    except Exception as e:
        print(e)
        db.rollback()

def write_in(file,mode,content):
    with open(file, mode) as f:
        f.write(content)


if __name__ == "__main__":

    db = MySQLdb.connect("localhost", "monitor", "password", "ais_project")
    quote_page, device_name, device_id = [], [], []
    curs = db.cursor()
    curs.execute("select * from belonging;")
    all_device_info = curs.fetchall()

    for each_device_info in all_device_info:
        device_page = []
        device_id.append(each_device_info[1])
        device_name.append(each_device_info[3])
        device_page.append('https://api.particle.io/v1/devices/%s/is_open?access_token=%s'%(each_device_info[1],each_device_info[2]))
        device_page.append('https://api.particle.io/v1/devices/%s/BME280temp?access_token=%s'%(each_device_info[1],each_device_info[2]))
        device_page.append('https://api.particle.io/v1/devices/%s/BME280hum?access_token=%s'%(each_device_info[1],each_device_info[2]))
        device_page.append('https://api.particle.io/v1/devices/%s/BME280bar?access_token=%s'%(each_device_info[1],each_device_info[2]))
        quote_page.append(device_page)

    write_in(error_log, 'w+', str(datetime.now())+'\n')

    while True:
        result=[]
        try:
            for each_device_page in quote_page:
                device_result = []
                for each_page in each_device_page:
                    s = requests.session()
                    response = s.get(each_page)
                    soup = BeautifulSoup(response.text,'html.parser')
                    device_result.append(str(soup).replace(':',",").split(',')[5])
                    s.keep_alive = False
                    time.sleep(1)
                result.append(device_result)

        except Exception as e :
            write_in(error_log, 'a', (str(e) + '\n'))
            print(e)
            time.sleep(1)
            continue

        insert_data(result)

        time.sleep(refreshing_time - 4)
