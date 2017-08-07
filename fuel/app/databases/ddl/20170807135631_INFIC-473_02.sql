USE [infic_batch_db]
GO

CREATE NONCLUSTERED INDEX [idx_bed_data_daily_002] ON [dbo].[bed_data_daily] (
	[measurement_time]
) INCLUDE ([parent_sensor_name], [sensor_name]) WITH (ONLINE = ON)
GO

