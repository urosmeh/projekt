import pymysql
import os
import requests

conn = pymysql.connect(host='localhost', user='root', password='', db='primerjalko')
db = conn.cursor()
sql = "select url from pictures;"
db.execute(sql)

countrows = db.execute(sql)
print("num of rows: ", countrows)

data = db.fetchall()
for row in data:
    print(row[0])