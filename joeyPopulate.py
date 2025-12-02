import mysql.connector
import json

db_key = ''

with open ('.database_key.json', 'r') as file:
    db_key = json.load(file);

sql_populate_file = open('populate_autogen.sql', 'w')

connection = mysql.connector.connect (
    host=db_key['servername'],
    port=3306,
    database=db_key['dbname'],
    user=db_key['username'],
    password=db_key['password']
)

cursor = connection.cursor()

for _ in range(100):
    smt = "INSERT INTO Swadesh VALUES ()"
    sql_populate_file.write(smt + ";\n")
    cursor.execute(smt)

connection.commit()

swId = 1
# populate WordID
for counter in range(1, 201, 2):
    language = ''

    # english all odd
    smt = f"INSERT INTO WordID VALUES ({swId}, {counter}, 'eng')"
    sql_populate_file.write(smt + ";\n")
    
    # print(smt)
    cursor.execute(smt)


    # german all even
    counter += 1
    smt = f"INSERT INTO WordID VALUES ({swId}, {counter}, 'deu')"
    sql_populate_file.write(smt + ";\n")
    # print(smt)

    cursor.execute(smt)

    # italian all negative odd
    ita_id = -1 * (counter - 1)
    smt = f"INSERT INTO WordID VALUES ({swId}, {ita_id}, 'ita')"
    sql_populate_file.write(smt + ";\n")
    # print(smt)

    cursor.execute(smt)

    swId += 1

connection.commit()


# populate English

english_file = open("EnglishSwadeshList", "r")
english_words = [line.rstrip() for line in english_file]
english_file.close()

for wordId in range(1, 201, 2):
    index = int((wordId + 1) / 2) - 1
    smt = f"INSERT INTO English VALUES ({wordId}, '{english_words[index]}')"
    sql_populate_file.write(smt + ";\n")
    
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

for wordId in range(2, 201, 2):
    index = int(wordId / 2) - 1
    current_word = deu_words[index]
    smt = ''

    if ' ' in current_word:
        word_array = current_word.split(" ")
        smt = f"INSERT INTO German VALUES ({wordId}, '{word_array[0]}', '{word_array[1]}')"
    else:
        smt = f"INSERT INTO German (WordID_wordID, translation) VALUES ({wordId}, '{current_word}')"

    sql_populate_file.write(smt + ";\n")
    #print(smt)
    cursor.execute(smt)

connection.commit()

# populate Italian

for wordId in range(1, 201, 2):
    index = int((wordId + 1) / 2) - 1 
    current_word = ita_words[index]
    smt = ''

    if ' ' in current_word:
        word_array = current_word.split(" ")
        smt = f"INSERT INTO Italian VALUES ({-wordId}, '{word_array[0]}', '{word_array[1]}')"
    else:
        smt = f"INSERT INTO Italian (WordID_wordID, translation) VALUES ({-wordId}, '{current_word}')"

    sql_populate_file.write(smt + ";\n")
    #print(smt)
    cursor.execute(smt)

connection.commit()

# populate POS

# bro I already know this is gonna be mega cancer

for swId in range(1, 101):
    pos = ''
    isConcrete = True
    isNoun = False

    if swId in [1, 2, 3]:
        pos = 'pronoun'
    elif swId in [4, 5]:
        pos = 'demonstrative'
    elif swId in [6, 7]:
        pos = 'inquisitive'
    elif swId in [8, 9, 10, 11, 12, 13, 14, 15]:
        pos = 'adjective'
    elif swId in list(range(16, 54)) or swId in list(range(72, 84)) or swId in list(range(85, 87)) or swId == 92 or swId == 100:
        pos = 'noun'
        isNoun = True
    elif swId in list(range(54, 72)) or swId == 84:
        pos = 'verb'
    elif swId in list(range(87, 92)) or swId in list(range(93, 100)):
        pos = 'adjective'
    
    if swId in [92, 100]:
        isConcrete = False
    
    if isNoun:
        smt = f"INSERT INTO Part_Of_Speech VALUES ({swId}, '{pos}', {isConcrete})"
    else:
        smt = f"INSERT INTO Part_Of_Speech (Swadesh_SwID, POS) VALUES ({swId}, '{pos}')"

    sql_populate_file.write(smt + ";\n")
    cursor.execute(smt)

connection.commit()

sql_populate_file.close()
cursor.close()
connection.close()
