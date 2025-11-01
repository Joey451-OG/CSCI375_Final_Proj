-- Created by Redgate Data Modeler (https://datamodeler.redgate-platform.com)
-- Last modification date: 2025-11-01 15:09:30.913

-- tables
-- Table: English
CREATE TABLE English (
    WordID_Lang int  NOT NULL,
    translation varchar(20)  NOT NULL,
    isFormal bool  NOT NULL,
    CONSTRAINT SwID PRIMARY KEY (WordID_Lang)
) COMMENT 'conjugationID could be used for plural and verb conjugations maybe?';

-- Table: German
CREATE TABLE German (
    WordID_Lang int  NOT NULL,
    translation varchar(40)  NOT NULL,
    isFormal bool  NOT NULL,
    CONSTRAINT German_pk PRIMARY KEY (WordID_Lang)
);

-- Table: Italian
CREATE TABLE Italian (
    WordID_Lang int  NOT NULL,
    translation varchar(25)  NOT NULL,
    isFormal bool  NOT NULL,
    CONSTRAINT Italian_pk PRIMARY KEY (WordID_Lang)
);

-- Table: Part_Of_Speech
CREATE TABLE Part_Of_Speech (
    Swadesh_SwID int  NOT NULL,
    POS char(10)  NOT NULL,
    isConcrete int  NULL,
    CONSTRAINT Part_Of_Speech_pk PRIMARY KEY (Swadesh_SwID)
);

-- Table: Swadesh
CREATE TABLE Swadesh (
    SwID int  NOT NULL AUTO_INCREMENT,
    CONSTRAINT SwID PRIMARY KEY (SwID)
);

-- Table: WordID
CREATE TABLE WordID (
    Swadesh_SwID int  NOT NULL,
    Lang int  NOT NULL,
    Gender char(3)  NOT NULL,
    wordID int  NOT NULL,
    CONSTRAINT WordID_pk PRIMARY KEY (Swadesh_SwID,Lang)
);

-- foreign keys
-- Reference: English_WordID (table: English)
ALTER TABLE English ADD CONSTRAINT English_WordID FOREIGN KEY English_WordID (WordID_Lang)
    REFERENCES WordID (Lang);

-- Reference: German_WordID (table: German)
ALTER TABLE German ADD CONSTRAINT German_WordID FOREIGN KEY German_WordID (WordID_Lang)
    REFERENCES WordID (Lang);

-- Reference: Italian_WordID (table: Italian)
ALTER TABLE Italian ADD CONSTRAINT Italian_WordID FOREIGN KEY Italian_WordID (WordID_Lang)
    REFERENCES WordID (Lang);

-- Reference: Part_Of_Speech_Swadesh (table: Part_Of_Speech)
ALTER TABLE Part_Of_Speech ADD CONSTRAINT Part_Of_Speech_Swadesh FOREIGN KEY Part_Of_Speech_Swadesh (Swadesh_SwID)
    REFERENCES Swadesh (SwID);

-- Reference: WordID_Swadesh (table: WordID)
ALTER TABLE WordID ADD CONSTRAINT WordID_Swadesh FOREIGN KEY WordID_Swadesh (Swadesh_SwID)
    REFERENCES Swadesh (SwID);

-- End of file.

