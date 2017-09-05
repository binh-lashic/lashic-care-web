-- for staging db
-- USE [infic-staging_db]
-- GO

-- for production db
-- USE [infic_test]
-- GO

CREATE NONCLUSTERED INDEX [IDX_data_daily_001] ON [dbo].[data_daily] ([id]) WITH (ONLINE = ON)

GO


