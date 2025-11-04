SELECT
    p.POS AS PartOfSpeech,
    COUNT(s.SwID) AS TotalWords
FROM
    Part_Of_Speech p
    INNER JOIN Swadesh s ON p.Swadesh_SwID = s.SwID
GROUP BY
    p.POS
ORDER BY
    TotalWords DESC;