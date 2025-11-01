import mysql.connector
import json

db_key = ''

with open ('.database_key.json', 'r') as file:
    db_key = json.load(file);

connection = mysql.connector.connect (
    host=db_key['servername'],
    port=3306,
    database=db_key['dbname'],
    user=db_key['username'],
    password=db_key['password']
)

cursor = connection.cursor()

for _ in range(100):
    cursor.execute("INSERT INTO Swadesh VALUES ()")


connection.commit()

cursor.close()
connection.close()
