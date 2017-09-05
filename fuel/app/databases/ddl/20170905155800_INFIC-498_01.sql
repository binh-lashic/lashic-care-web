-- for staging db
-- USE [infic-staging_db]
-- GO

-- for production db
-- USE [infic_test]
-- GO

CREATE NONCLUSTERED INDEX [IDX_alerts_002] ON [dbo].[alerts] ([type], [sensor_id]) INCLUDE ([confirm_status], [date]) WITH (ONLINE = ON)

GO


