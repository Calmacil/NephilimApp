--
-- :author: Calmacil <togo.harrian@gmail.com>
--
-- create the calendar_event table; date is the primary key and there is one event per day, so simple date
--

CREATE TABLE `calendar_event` (
  `date` DATE NOT NULL,
  `content` TEXT
);

ALTER TABLE `calendar_event` ADD CONSTRAINT pk_calendar_event PRIMARY KEY(`date`);
