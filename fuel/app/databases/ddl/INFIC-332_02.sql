-- for staging db
-- USE [infic-staging_db]
-- GO

-- for production db
-- USE [infic_test]
-- GO


DECLARE @ConstraintName nvarchar(200)

SELECT @ConstraintName = obj.name FROM sys.objects AS obj
JOIN sys.columns AS clm ON obj.object_id = clm.default_object_id
WHERE obj.type = 'D' AND obj.parent_object_id = OBJECT_ID('user_sensors') AND clm.name = 'snooze_times'

IF @ConstraintName IS NOT NULL
    EXEC('ALTER TABLE [dbo].[user_sensors] DROP CONSTRAINT ' + @ConstraintName)
GO

ALTER TABLE [dbo].[user_sensors] DROP COLUMN [snooze_times];
GO


