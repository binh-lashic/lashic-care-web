SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[agents](
    [store_id] [int] IDENTITY(1,1) NOT NULL,
	[agent_code] [nvarchar] NOT NULL,
	[agent_name] [nvarchar] NOT NULL
)
GO
CREATE TABLE [dbo].[stores](
    [id] [int] IDENTITY(1,1) NOT NULL,
	[store_name] [nvarchar] NOT NULL
)
GO