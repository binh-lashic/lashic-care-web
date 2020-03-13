SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[agents](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[store_id] [int] NOT NULL,
	[agent_code] [nvarchar] (50) NOT NULL,
	[agent_name] [nvarchar] (50) NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL
)
GO
CREATE TABLE [dbo].[stores](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[store_name] [nvarchar] (50)  NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL
)
GO
ALTER TABLE [dbo].[contracts] ADD agent_code nvarchar(50) NULL