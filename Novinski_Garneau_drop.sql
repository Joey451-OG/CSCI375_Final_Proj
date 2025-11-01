-- Created by Redgate Data Modeler (https://datamodeler.redgate-platform.com)
-- Last modification date: 2025-11-01 16:10:42.774

-- foreign keys
ALTER TABLE English
    DROP FOREIGN KEY English_WordID;

ALTER TABLE German
    DROP FOREIGN KEY German_WordID;

ALTER TABLE Italian
    DROP FOREIGN KEY Italian_WordID;

ALTER TABLE Part_Of_Speech
    DROP FOREIGN KEY Part_Of_Speech_Swadesh;

ALTER TABLE WordID
    DROP FOREIGN KEY WordID_Swadesh;

-- tables
DROP TABLE English;

DROP TABLE German;

DROP TABLE Italian;

DROP TABLE Part_Of_Speech;

DROP TABLE Swadesh;

DROP TABLE WordID;

-- End of file.

