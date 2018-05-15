SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[nurse_call_data_daily](
	[id] [int] IDENTITY (1, 1) NOT NULL,
	[sensor_name] [nvarchar](255) NOT NULL,
	[status] [int] NOT NULL,
	[measurement_time] [datetime] NOT NULL,
	[created_at] [datetime] NOT NULL
) ON [PRIMARY]

GO
ALTER TABLE [dbo].[nurse_call_data_daily] ADD PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON

GO
CREATE NONCLUSTERED INDEX [idx_nurse_call_data_daily_001] ON [dbo].[nurse_call_data_daily]
(
	[sensor_name] ASC,
	[measurement_time] ASC
)WITH (STATISTICS_NORECOMPUTE = OFF, DROP_EXISTING = OFF, ONLINE = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON

GO
ALTER TABLE [dbo].[nurse_call_data_daily] ADD  DEFAULT (NEXT VALUE FOR [nurse_call_data_daily_id_counter]) FOR [id]
GO
ALTER TABLE [dbo].[nurse_call_data_daily] ADD  DEFAULT (dateadd(hour,(9),getutcdate())) FOR [created_at]
GO