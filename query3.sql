SELECT
    CASE 
        WHEN p.isConcrete = 1 THEN 'Concrete Nouns'
        ELSE 'Non-Concrete Nouns'
    END AS NounType,
    COUNT(s.SwID) AS TotalCount
FROM
    Part_Of_Speech p
    INNER JOIN Swadesh s ON p.Swadesh_SwID = s.SwID
WHERE
    p.POS = 'noun'
GROUP BY
    p.isConcrete
ORDER BY
    TotalCount DESC;