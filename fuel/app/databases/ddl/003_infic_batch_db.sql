USE [master]
GO
/****** Object:  Database [infic_batch_db]    Script Date: 4/24/2017 1:39:33 AM ******/
CREATE DATABASE [infic_batch_db]
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [infic_batch_db].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [infic_batch_db] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [infic_batch_db] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [infic_batch_db] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [infic_batch_db] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [infic_batch_db] SET ARITHABORT OFF 
GO
ALTER DATABASE [infic_batch_db] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [infic_batch_db] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [infic_batch_db] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [infic_batch_db] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [infic_batch_db] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [infic_batch_db] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [infic_batch_db] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [infic_batch_db] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [infic_batch_db] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [infic_batch_db] SET  ENABLE_BROKER 
GO
ALTER DATABASE [infic_batch_db] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [infic_batch_db] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [infic_batch_db] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [infic_batch_db] SET ALLOW_SNAPSHOT_ISOLATION ON 
GO
ALTER DATABASE [infic_batch_db] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [infic_batch_db] SET READ_COMMITTED_SNAPSHOT ON 
GO
ALTER DATABASE [infic_batch_db] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [infic_batch_db] SET RECOVERY FULL 
GO
ALTER DATABASE [infic_batch_db] SET  MULTI_USER 
GO
ALTER DATABASE [infic_batch_db] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [infic_batch_db] SET DB_CHAINING OFF 
GO
USE [infic_batch_db]
GO
/****** Object:  Table [dbo].[bed_data_daily]    Script Date: 4/24/2017 1:39:33 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bed_data_daily](
	[id] [int] NOT NULL DEFAULT (NEXT VALUE FOR [bed_data_daily_id_counter]),
	[sensor_name] [nvarchar](255) NOT NULL,
	[parent_sensor_name] [nvarchar](255) NULL,
	[humans] [int] NOT NULL,
	[motion] [int] NOT NULL,
	[posture] [int] NOT NULL,
	[sleep] [int] NOT NULL,
	[rolling] [int] NOT NULL,
	[pulse] [int] NULL,
	[measurement_time] [datetime] NOT NULL,
	[created_at] [datetime] NOT NULL DEFAULT (dateadd(hour,(9),getutcdate())),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Table [dbo].[daily_enable_sensors]    Script Date: 4/24/2017 1:39:33 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[daily_enable_sensors](
	[sensor_name] [nvarchar](255) NOT NULL,
	[date] [date] NOT NULL,
	[sensor_type] [nvarchar](255) NOT NULL,
	[wake_up_started_at] [datetime] NOT NULL,
	[wake_up_ended_at] [datetime] NOT NULL,
	[sleep_started_at] [datetime] NOT NULL,
	[sleep_ended_at] [datetime] NOT NULL,
	[wake_up_time_processed] [bit] NOT NULL DEFAULT ((0)),
	[last_sleep_time_processed] [bit] NOT NULL DEFAULT ((0)),
PRIMARY KEY CLUSTERED 
(
	[sensor_name] ASC,
	[date] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Table [dbo].[data_daily]    Script Date: 4/24/2017 1:39:33 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[data_daily](
	[id] [int] NOT NULL DEFAULT (NEXT VALUE FOR [data_daily_id_counter]),
	[sensor_name] [nvarchar](255) NOT NULL,
	[parent_sensor_name] [nvarchar](255) NULL,
	[humidity] [float] NULL,
	[illuminance] [int] NULL,
	[activity] [float] NULL,
	[temperature] [float] NULL,
	[measurement_time] [datetime] NOT NULL,
	[created_at] [datetime] NOT NULL DEFAULT (dateadd(hour,(9),getutcdate())),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
SET ANSI_PADDING ON

GO
/****** Object:  Index [idx_bed_data_daily_001]    Script Date: 4/24/2017 1:39:33 AM ******/
CREATE NONCLUSTERED INDEX [idx_bed_data_daily_001] ON [dbo].[bed_data_daily]
(
	[sensor_name] ASC,
	[measurement_time] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
GO
SET ANSI_PADDING ON

GO
/****** Object:  Index [idx_data_daily_001]    Script Date: 4/24/2017 1:39:33 AM ******/
CREATE NONCLUSTERED INDEX [idx_data_daily_001] ON [dbo].[data_daily]
(
	[sensor_name] ASC,
	[measurement_time] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
GO
USE [master]
GO
ALTER DATABASE [infic_batch_db] SET  READ_WRITE 
GO
