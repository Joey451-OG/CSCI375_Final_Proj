SELECT
    g.translation AS GermanWord
FROM
    German g
    INNER JOIN WordID w ON g.WordID_wordID = w.wordID
WHERE
    w.Swadesh_SwID IN (
        SELECT
            w2.Swadesh_SwID
        FROM
            WordID w2
            INNER JOIN German g2 ON w2.wordID = g2.WordID_wordID
        WHERE
            g2.gender = 'f'
    )
ORDER BY
    g.translation;