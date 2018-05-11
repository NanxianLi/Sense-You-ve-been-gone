
import matplotlib
matplotlib.use('Agg')
import sys
import MySQLdb
import matplotlib.pyplot as plt

temp_unit = sys.argv[1]
bar_unit = sys.argv[2]
selected_sensor = sys.argv[3]

def flatten(iterables):
    list1 = []
    for i in (elem for iterable in iterables for elem in iterable):
        list1.append(i)
    return list1

def fix_units(bar_unit,temp_unit,data,data_type):
  f_temp, pa_bar=[],[]
  if data_type == "temp":
    if temp_unit == "F":
      f_temp = [((i*9)/5)+32 for i in flatten(data)]
      return f_temp
    else:
      return data

  if data_type == "bar":
    if bar_unit == "kPa":
      pa_bar = [j*3.38639 for j in flatten(data)]
      return pa_bar
    else:
      return data
  else:
    return data


def query_data(data_type):
  db = MySQLdb.connect('localhost','monitor','password','ais_project')
  curs = db.cursor()
  curs.execute ("SELECT %s FROM sensor_data where time > (NOW()-1000000) and device_na$

  raw_data = curs.fetchall()
  data = fix_units(bar_unit,temp_unit,raw_data,data_type)

  y_label="Temperature"
  if data_type == "hum":
    y_label="Humidity"
  if data_type == "bar":
    y_label="Pressure"

  plt.plot(range(0,15*len(data),15),data)
  ax = plt.gca()
  ax.invert_xaxis()
  plt.xlabel('Time(mins ago)')
  plt.ylabel(y_label)
  plt.savefig("/var/www/html/%s_plot.png"%(data_type))
  plt.clf()
  curs.close()
  db.close()

query_data("temp")
query_data("hum")
query_data("bar")

