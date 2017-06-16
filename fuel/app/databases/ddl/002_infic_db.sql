USE [infic_db]
GO

/****** Object:  Table [infic_api].[data]    Script Date: 4/24/2017 1:38:30 AM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [infic_api].[data](
	[id] [nvarchar](255) NOT NULL CONSTRAINT [DF_data_id]  DEFAULT (CONVERT([nvarchar](255),newid(),(0))),
	[__createdAt] [datetimeoffset](3) NOT NULL CONSTRAINT [DF_data___createdAt]  DEFAULT (CONVERT([datetimeoffset](3),sysutcdatetime(),(0))),
	[__updatedAt] [datetimeoffset](3) NULL,
	[__version] [timestamp] NOT NULL,
	[__deleted] [bit] NOT NULL DEFAULT ((0)),
	[corporate_id] [nvarchar](max) NULL,
	[sensor_id] [nvarchar](450) NULL,
	[date] [nvarchar](450) NULL,
	[humidity] [nvarchar](max) NULL,
	[illuminance] [nvarchar](max) NULL,
	[active] [float] NULL,
	[temperature] [float] NULL,
PRIMARY KEY NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO

