USE [infic_batch_db]
GO

CREATE NONCLUSTERED INDEX [idx_data_daily_002] ON [dbo].[data_daily]
(
	[sensor_name],
	[measurement_time]
) INCLUDE ([activity], [humidity], [illuminance], [temperature]) WITH (ONLINE = ON)
GO
