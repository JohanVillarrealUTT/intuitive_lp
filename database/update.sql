update migrations
set migration = '2021_05_27_212114_alter_subscriber_table_add_available_collumn'
where id = 13;

update migrations
set migration = '2021_05_28_180406_alter_subscriber_table_add_some_collumns'
where id = 14;

INSERT INTO labels (created_at, updated_at, color, NAME)
SELECT 
NOW(),
NOW(),
CASE
	WHEN color_tag = 'blue' THEN '#83c7e3'
	WHEN color_tag = 'purple' THEN '#d5a7dc'
	WHEN color_tag = 'green' THEN '#8fd179'
	WHEN color_tag = 'gray' THEN '#eee'
	WHEN color_tag = 'red' THEN '#ea927e'
	ELSE '#e8b771'
END AS 'color',
color_tag AS 'NAME'
FROM subscribers GROUP BY color_tag;

UPDATE subscribers AS s
INNER JOIN labels AS l ON l.name = s.color_tag
SET label_id = l.id;

SELECT color_tag, l.color, l.name FROM subscribers AS s
INNER JOIN labels AS l ON l.id = s.label_id;

INSERT INTO appointment_subscriber (created_at, updated_at,appointment_hour_id,subscriber_id, created_by, STATUS)
SELECT 
	NOW(), 
	NOW(), 
	appointment_hour_id, 
	s.id, 
	'subscriber',
	IF (DATE(ad.date) >= now(), 'programada', NULL) AS 'status'
	
FROM subscribers AS s
INNER JOIN appointment_hours AS ah ON s.appointment_hour_id = ah.id
INNER JOIN appointment_dates AS ad ON ad.id = ah.appointment_date_id
WHERE appointment_hour_id IS NOT NULL;
