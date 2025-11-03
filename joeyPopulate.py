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
    
    #print(smt)
    cursor.execute(smt)

connection.commit()


# populate English

english_file = open("EnglishSwadeshList", "r")
english_words = [line.rstrip() for line in english_file]
english_file.close()

for wordId in range(1, 101):
    smt = f"INSERT INTO English VALUES ({wordId}, '{english_words[wordId - 1]}')"
    
    #print(smt)
    cursor.execute(smt)

connection.commit()

# set up German and Itialian

deu_and_ita_file = open("GermanAndItalianWithGerndersIncluded")
deu_and_ita = [line.rstrip() for line in deu_and_ita_file]
deu_and_ita_file.close()

deu_words = [deu_and_ita[index] for index in range(100)]
ita_words = [deu_and_ita[index] for index in range(100, 200)]

# populare German

for wordId in range(100, 200):
    current_word = deu_words[wordId - 100]
    smt = ''

    if ' ' in current_word:
        word_array = current_word.split(" ")
        smt = f"INSERT INTO German VALUES ({wordId}, '{word_array[0]}', '{word_array[1]}')"
    else:
        smt = f"INSERT INTO German (WordID_wordID, translation) VALUES ({wordId}, '{current_word}')"

    print(smt)
    cursor.execute(smt)


connection.commit()

cursor.close()
connection.close()
