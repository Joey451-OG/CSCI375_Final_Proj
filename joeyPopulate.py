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

# populate WordID
for counter in range(1, 301):
    language = ''
    swId = counter

    if counter <= 100 and not counter > 100:
        language = 'eng'
    if counter > 100 and not counter > 200:
        language = 'deu'
        swId = counter - 100
    if counter > 200:
        language = 'ita'
        swId = counter - 200
    
    smt = f"INSERT INTO WordID VALUES ({swId}, {counter}, '{language}')"
    print(smt)
    cursor.execute(smt)

connection.commit()



cursor.close()
connection.close()
