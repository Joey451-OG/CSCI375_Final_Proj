-- Created by Redgate Data Modeler (https://datamodeler.redgate-platform.com)
-- Last modification date: 2025-11-03 22:02:51.578

-- tables
-- Table: English
CREATE TABLE English (
    WordID_wordID int  NOT NULL,
    translation varchar(20)  NOT NULL,
    CONSTRAINT English_pk PRIMARY KEY (WordID_wordID)
) COMMENT 'conjugationID could be used for plural and verb conjugations maybe?';

-- Table: German
CREATE TABLE German (
    WordID_wordID int  NOT NULL,
    translation varchar(40)  NOT NULL,
    gender char(3)  NULL,
    CONSTRAINT German_pk PRIMARY KEY (WordID_wordID)
);

-- Table: Italian
CREATE TABLE Italian (
    WordID_wordID int  NOT NULL,
    translation varchar(25)  NOT NULL,
    gender char(3)  NULL,
    CONSTRAINT Italian_pk PRIMARY KEY (WordID_wordID)
);

-- Table: Part_Of_Speech
CREATE TABLE Part_Of_Speech (
    Swadesh_SwID int  NOT NULL,
    POS varchar(20)  NOT NULL,
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
    wordID int  NOT NULL,
    Lang char(3)  NOT NULL,
    UNIQUE INDEX wordID (wordID),
    CONSTRAINT WordID_pk PRIMARY KEY (Swadesh_SwID,wordID)
);

-- foreign keys
-- Reference: English_WordID (table: English)
ALTER TABLE English ADD CONSTRAINT English_WordID FOREIGN KEY English_WordID (WordID_wordID)
    REFERENCES WordID (wordID);

-- Reference: German_WordID (table: German)
ALTER TABLE German ADD CONSTRAINT German_WordID FOREIGN KEY German_WordID (WordID_wordID)
    REFERENCES WordID (wordID);

-- Reference: Italian_WordID (table: Italian)
ALTER TABLE Italian ADD CONSTRAINT Italian_WordID FOREIGN KEY Italian_WordID (WordID_wordID)
    REFERENCES WordID (wordID);

-- Reference: Part_Of_Speech_Swadesh (table: Part_Of_Speech)
ALTER TABLE Part_Of_Speech ADD CONSTRAINT Part_Of_Speech_Swadesh FOREIGN KEY Part_Of_Speech_Swadesh (Swadesh_SwID)
    REFERENCES Swadesh (SwID);

-- Reference: WordID_Swadesh (table: WordID)
ALTER TABLE WordID ADD CONSTRAINT WordID_Swadesh FOREIGN KEY WordID_Swadesh (Swadesh_SwID)
    REFERENCES Swadesh (SwID);

-- End of file.

