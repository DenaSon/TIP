/* =========================================================
   TIP AUDIT V2
   Baseline Audit Queries
   ========================================================= */


/* =========================================================
   1. COVERAGE
   ========================================================= */

SELECT
    COUNT(*) AS total_contents,
    COUNT(DISTINCT ct.content_id) AS assigned_contents,
    COUNT(*) - COUNT(DISTINCT ct.content_id) AS unassigned_contents,
    ROUND(
        COUNT(DISTINCT ct.content_id) * 100.0
            / COUNT(*),
        2
    ) AS coverage_percent
FROM contents c
         LEFT JOIN content_topic ct
                   ON ct.content_id = c.id;


/* =========================================================
   2. TOPIC DISTRIBUTION
   ========================================================= */

SELECT
    t.id,
    t.name,
    COUNT(ct.content_id) AS matches
FROM topics t
         LEFT JOIN content_topic ct
                   ON ct.topic_id = t.id
GROUP BY t.id, t.name
ORDER BY matches DESC;


/* =========================================================
   3. TREND METRICS
   ========================================================= */

SELECT
    t.id,
    t.name,
    tr.growth_rate,
    tr.velocity,
    tr.authority_score,
    tr.score
FROM trends tr
         JOIN topics t
              ON t.id = tr.topic_id
ORDER BY tr.score DESC;


/* =========================================================
   4. OPPORTUNITY RANKING
   ========================================================= */

SELECT
    o.title,
    o.score,
    o.reason,
    tr.growth_rate,
    tr.velocity,
    tr.authority_score
FROM opportunities o
         JOIN trends tr
              ON tr.id = o.trend_id
ORDER BY o.score DESC;


/* =========================================================
   5. UNASSIGNED CONTENT SAMPLE
   ========================================================= */

SELECT
    c.id,
    c.title,
    s.name AS source
FROM contents c
         JOIN sources s
              ON s.id = c.source_id
WHERE NOT EXISTS (
    SELECT 1
    FROM content_topic ct
    WHERE ct.content_id = c.id
)
ORDER BY c.published_at DESC
    LIMIT 50;


/* =========================================================
   6. SOURCE COVERAGE GAP
   ========================================================= */

SELECT
    s.name,
    COUNT(*) AS missed
FROM contents c
         JOIN sources s
              ON s.id = c.source_id
WHERE NOT EXISTS (
    SELECT 1
    FROM content_topic ct
    WHERE ct.content_id = c.id
)
GROUP BY s.id, s.name
ORDER BY missed DESC;


/* =========================================================
   7. TOPIC OVERLAP
   ========================================================= */

SELECT
    c.id,
    c.title,
    COUNT(ct.topic_id) AS matched_topics
FROM contents c
         JOIN content_topic ct
              ON ct.content_id = c.id
GROUP BY c.id, c.title
HAVING matched_topics > 1
ORDER BY matched_topics DESC
    LIMIT 50;


/* =========================================================
   8. OVERLAP DISTRIBUTION
   ========================================================= */

SELECT
    matched_topics,
    COUNT(*) AS contents
FROM (
         SELECT
             content_id,
             COUNT(topic_id) AS matched_topics
         FROM content_topic
         GROUP BY content_id
     ) x
GROUP BY matched_topics
ORDER BY matched_topics DESC;


/* =========================================================
   9. TOP MATCHES PER TOPIC
   (replace topic_id manually)
   ========================================================= */

SELECT
    c.title,
    ctm.score,
    ctm.matched_keywords
FROM content_topic_matches ctm
         JOIN contents c
              ON c.id = ctm.content_id
WHERE ctm.topic_id = 1
ORDER BY ctm.score DESC
    LIMIT 30;


/* =========================================================
   10. SNAPSHOT COUNTS
   ========================================================= */

SELECT
    t.id,
    t.name,
    COUNT(ts.id) AS snapshots
FROM topics t
         LEFT JOIN trend_snapshots ts
                   ON ts.topic_id = t.id
GROUP BY t.id, t.name
ORDER BY snapshots DESC;


/* =========================================================
   11. CONTENT PER SOURCE
   ========================================================= */

SELECT
    s.name,
    COUNT(c.id) AS contents
FROM sources s
         LEFT JOIN contents c
                   ON c.source_id = s.id
GROUP BY s.id, s.name
ORDER BY contents DESC;


/* =========================================================
   12. CONTENT_TOPIC_MATCH SCORE DISTRIBUTION
   ========================================================= */

SELECT
    CASE
        WHEN score >= 300 THEN '300+'
        WHEN score >= 200 THEN '200-299'
        WHEN score >= 100 THEN '100-199'
        WHEN score >= 50 THEN '50-99'
        ELSE '<50'
        END AS score_range,
    COUNT(*) AS matches_count
FROM content_topic_matches
GROUP BY score_range
ORDER BY matches_count DESC;


/* =========================================================
   13. TOP 50 STRONGEST MATCHES
   ========================================================= */

SELECT
    t.name AS topic,
    c.title,
    ctm.score
FROM content_topic_matches ctm
         JOIN topics t
              ON t.id = ctm.topic_id
         JOIN contents c
              ON c.id = ctm.content_id
ORDER BY ctm.score DESC
    LIMIT 50;


/* =========================================================
   END
   ========================================================= */
