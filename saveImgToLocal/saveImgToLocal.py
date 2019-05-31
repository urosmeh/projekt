import pymysql

conn = pymysql.connect(host='localhost', user='root', password='', db='primerjalko')
db = conn.cursor()
sql = "select * from products;"

countrows = db.execute(sql)
print("num of rows: ", countrows)
data = db.fetchone()
print(data)