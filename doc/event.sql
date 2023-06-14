CREATE DEFINER=`root`@`localhost` 
EVENT `ResetDays&Credits` 
ON SCHEDULE EVERY 1 YEAR STARTS '2023-01-01 22:19:15' 
ON COMPLETION NOT PRESERVE 
ENABLE COMMENT 'évènement qui reset les jours et credits de formations ' 
DO UPDATE employe SET jours = 15, credits = 5000;