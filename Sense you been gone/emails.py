#!/usr/bin/python
import sys
import smtplib

def send_email(to_email, act_code):
    server = smtplib.SMTP('smtp.gmail.com',587)
    server.starttls()
    server.login('projecttestingcmu@gmail.com',"ProjectTesting")

    server.sendmail('projecttestingcmu@gmail.com',to_email,act_code)
    server.quit()


if __name__ == "__main__":
    to_email = sys.argv[1]
    act_code = sys.argv[2]
    send_email(to_email, act_code)


