import pymysql
import os
import requests
from pathlib import Path
conn = pymysql.connect(host='localhost', user='root', password='', db='primerjalko')
db = conn.cursor()
sql = "select url from pictures;"
db.execute(sql)

#countrows = db.execute(sql)
#print("num of rows: ", countrows)

data = db.fetchall();
for row in data:
    #print(row[0])
    imgurl = row[0]
    #sqlImgId = "select ID from pictures where url=%s, "
    db.execute("select ID from pictures where url = (%s)", imgurl)
    id = db.fetchall()
    filename = (id[0][0])
    #print(filename)
    #print(row[0])
    url = row[0]
    filename = url.split('/')[-1]
    ext = filename.split('.')
    filename =  str(id[0][0]) + '.' + ext[-1]
    #print(filename)
    #print(tmp[-1])
    r = requests.get(url, allow_redirects=True)
    open(filename, 'wb').write(r.content)