CREATE DATABASE `citrix`;
GRANT SELECT ON `citrix`.* TO citrix IDENTIFIED BY 'citrix';

USE citrix;

CREATE TABLE logon_times_tmp (
    logon_time_ms INT NOT NULL,
    start_date DATETIME NOT NULL
);

LOAD DATA INFILE '/docker-entrypoint-initdb.d/citrix_login_times.csv' INTO TABLE logon_times_tmp
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
IGNORE 1 LINES;

CREATE TABLE logon_times (
    year INT NOT NULL,
    doy INT NOT NULL COMMENT 'Day of year 1-366',
    start_date TIMESTAMP NOT NULL COMMENT 'Start of the login process',
    logon_time_ms INT NOT NULL COMMENT 'Time to complete the logon process in MS',
    INDEX(year),
    INDEX(doy)
) COMMENT 'Citrix logon times raw data'
AS SELECT
    YEAR(start_Date) AS year,
    DAYOFYEAR(start_Date) AS doy,
    start_date,
    logon_time_ms
FROM logon_times_tmp
;

DROP TABLE logon_times_tmp;

CREATE TABLE scripts (
    prescription_id INT,
    mrn INT,
    date_written DATETIME,
    generic VARCHAR(32),
    drug VARCHAR(64),
    KEY (mrn, date_written, generic)
);

INSERT INTO scripts VALUES
(1, 100, '2020-01-01 09:00:00', 'morphine', 'morphine 5mg'),
(2, 100, '2020-01-01 11:00:00', 'morphine', 'morphine 7mg'),
(3, 100, '2020-01-31 09:00:00', 'morphine', 'morphine 5mg'),
(4, 100, '2020-01-31 14:00:00', 'morphine', 'morphine 10mg'),
(5, 100, '2020-01-31 13:00:00', 'morphine', 'morphine 5mg'),
(6, 200, '2020-01-01 09:00:00', 'morphine', 'morphine 5mg'),
(7, 300, '2020-02-01 09:00:00', 'oxycodone', 'acetaminophen-oxycodone 10mg'),
(8, 400, '2020-02-02 06:00:00', 'oxycodone', 'acetaminophen-oxycodone 10mg'),
(9, 400, '2020-02-02 08:00:00', 'oxycodone', 'acetaminophen-oxycodone 10mg'),
(10, 400, '2020-02-02 11:00:00', 'oxycodone', 'acetaminophen-oxycodone 10mg'),
(11, 500, '2020-03-01 09:00:00', 'morphine', 'morphine 5mg'),
(12, 500, '2020-03-01 11:00:00', 'morphine', 'morphine 5mg'),
(13, 500, '2020-03-01 13:00:00', 'oxycodone', 'acetaminophen-oxycodone 5mg'),
(14, 500, '2020-03-02 09:00:00', 'oxycodone', 'acetaminophen-oxycodone 10mg'),
(15, 600, '2020-03-01 09:00:00', 'hydrocodone', 'hydrocodone 7.5mg'),
(16, 600, '2020-03-01 08:00:00', 'morphine', 'morphine 11mg'),
(17, 600, '2020-03-01 07:00:00', 'morphine', 'morphine 5mg'),
(18, 700, '2020-03-01 09:00:00', 'hydrocodone', 'hydrocodone 7.5mg')
;



