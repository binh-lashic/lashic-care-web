USE [master]
GO
/****** Object:  Database [infic_test]    Script Date: 4/24/2017 1:12:31 AM ******/
CREATE DATABASE [infic_test]
GO
ALTER DATABASE [infic_test] SET COMPATIBILITY_LEVEL = 120
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [infic_test].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [infic_test] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [infic_test] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [infic_test] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [infic_test] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [infic_test] SET ARITHABORT OFF 
GO
ALTER DATABASE [infic_test] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [infic_test] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [infic_test] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [infic_test] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [infic_test] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [infic_test] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [infic_test] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [infic_test] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [infic_test] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [infic_test] SET  ENABLE_BROKER 
GO
ALTER DATABASE [infic_test] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [infic_test] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [infic_test] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [infic_test] SET ALLOW_SNAPSHOT_ISOLATION ON 
GO
ALTER DATABASE [infic_test] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [infic_test] SET READ_COMMITTED_SNAPSHOT ON 
GO
ALTER DATABASE [infic_test] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [infic_test] SET RECOVERY FULL 
GO
ALTER DATABASE [infic_test] SET  MULTI_USER 
GO
ALTER DATABASE [infic_test] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [infic_test] SET DB_CHAINING OFF 
GO
USE [infic_test]
GO
/****** Object:  Table [dbo].[addresses]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[addresses](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NULL,
	[zip_code] [nvarchar](45) NULL,
	[prefecture] [nvarchar](45) NULL,
	[address] [ntext] NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[last_name] [nvarchar](45) NULL,
	[first_name] [nvarchar](45) NULL,
	[last_kana] [nvarchar](45) NULL,
	[first_kana] [nvarchar](45) NULL,
	[phone] [nvarchar](45) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Table [dbo].[alerts]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[alerts](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[title] [nvarchar](255) NULL,
	[sensor_id] [int] NULL,
	[date] [datetime] NULL,
	[category] [nvarchar](50) NULL,
	[type] [nvarchar](50) NULL,
	[reason] [ntext] NULL,
	[confirm_status] [int] NULL DEFAULT ((0)),
	[confirm_user_id] [int] NULL,
	[confirm_date] [date] NULL,
	[responder_user_id] [int] NULL,
	[corresponding_type] [int] NULL,
	[expected_description] [ntext] NULL,
	[description] [ntext] NULL,
	[corresponding_status] [int] NULL,
	[report_description] [ntext] NULL,
	[manager_confirm_status] [int] NULL,
	[corresponding_date] [date] NULL,
	[corresponding_time] [time](7) NULL,
	[corresponding_description] [ntext] NULL,
	[corresponding_user_id] [int] NULL,
	[expiration_time] [datetime] NULL,
	[snoose_count] [int] NULL,
	[snooze_count] [int] NULL DEFAULT ((0)),
 CONSTRAINT [PK_alert_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Table [dbo].[contract_payments]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[contract_payments](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[contract_id] [int] NOT NULL,
	[payment_id] [int] NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Table [dbo].[contract_sensors]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[contract_sensors](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[contract_id] [int] NULL,
	[sensor_Id] [int] NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Table [dbo].[contracts]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[contracts](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NOT NULL,
	[plan_id] [int] NOT NULL,
	[client_user_id] [nvarchar](45) NULL,
	[start_date] [date] NULL,
	[end_date] [date] NULL,
	[renew_date] [date] NULL,
	[price] [int] NULL,
	[status] [int] NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[prefecture] [nvarchar](45) NULL,
	[address] [ntext] NULL,
	[zip_code] [nvarchar](45) NULL,
	[shipping] [int] NULL,
	[affiliate] [nvarchar](45) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Table [dbo].[data_daily]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[data_daily](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[sensor_id] [int] NULL,
	[date] [date] NULL,
	[wake_up_time] [datetime] NULL,
	[sleep_time] [datetime] NULL,
	[wake_up_time_average] [time](7) NULL,
	[sleep_time_average] [time](7) NULL,
	[temperature_average] [float] NULL,
	[humidity_average] [float] NULL,
	[active_average] [float] NULL,
	[illuminance_average] [int] NULL
)

GO
/****** Object:  Table [dbo].[devices]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[devices](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NULL,
	[device_id] [nvarchar](255) NULL,
	[os] [nvarchar](10) NULL,
	[push_id] [nvarchar](255) NULL
)

GO
/****** Object:  Table [dbo].[logs]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[logs](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[date] [datetime] NULL,
	[user_id] [int] NULL,
	[description] [ntext] NULL,
	[data] [ntext] NULL
)

GO
/****** Object:  Table [dbo].[options]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[options](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[title] [ntext] NULL,
	[price] [int] NULL,
	[continuation] [int] NULL,
	[free_period] [int] NULL,
	[type] [nvarchar](45) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[unit_price] [int] NULL DEFAULT ((0)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Table [dbo].[payments]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[payments](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NOT NULL,
	[title] [nvarchar](45) NOT NULL,
	[date] [date] NOT NULL,
	[price] [int] NOT NULL DEFAULT ((0)),
	[tax] [int] NOT NULL DEFAULT ((0)),
	[shipping] [int] NOT NULL DEFAULT ((0)),
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Table [dbo].[plan_options]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[plan_options](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[plan_id] [int] NOT NULL,
	[option_id] [int] NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Table [dbo].[plans]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[plans](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[title] [nvarchar](255) NULL,
	[type] [nvarchar](45) NULL,
	[start_time] [datetime] NULL,
	[end_time] [datetime] NULL,
	[span] [int] NULL DEFAULT ((0)),
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Table [dbo].[sensors]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[sensors](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](50) NULL,
	[temperature_upper_limit] [int] NULL,
	[temperature_lower_limit] [int] NULL,
	[temperature_duration] [int] NULL,
	[fire_temperature_upper_limit] [int] NULL,
	[heatstroke_wbgt_upper_limit] [int] NULL,
	[heatstroke_duration] [int] NULL,
	[humidity_upper_limit] [int] NULL,
	[humidity_lower_limit] [int] NULL,
	[humidity_duration] [int] NULL,
	[mold_mites_temperature_upper_limit] [int] NULL,
	[mold_mites_duration] [int] NULL,
	[illuminance_daytime_lower_limit] [int] NULL,
	[illuminance_daytime_duration] [int] NULL,
	[mold_mites_humidity_upper_limit] [int] NULL,
	[illuminance_daytime_start_time] [int] NULL,
	[illuminance_daytime_end_time] [int] NULL,
	[illuminance_night_lower_limit] [int] NULL,
	[illuminance_night_duration] [int] NULL,
	[illuminance_night_start_time] [int] NULL,
	[illuminance_night_end_time] [int] NULL,
	[disconnection_duration] [int] NULL,
	[wake_up_period] [int] NULL,
	[wake_up_delay_allowance_duration] [int] NULL,
	[wake_up_start_time] [int] NULL,
	[wake_up_end_time] [int] NULL,
	[wake_up_threshold] [int] NULL,
	[wake_up_duration] [int] NULL,
	[wake_up_ignore_duration] [int] NULL,
	[sleep_start_time] [int] NULL,
	[sleep_end_time] [int] NULL,
	[sleep_threshold] [int] NULL,
	[sleep_duration] [int] NULL,
	[sleep_ignore_duration] [int] NULL,
	[temperature_average] [float] NULL,
	[humidity_average] [float] NULL,
	[temperature_week_average] [ntext] NULL,
	[humidity_week_average] [ntext] NULL,
	[temperature_level] [int] NULL DEFAULT ((2)),
	[fire_level] [int] NULL DEFAULT ((2)),
	[heatstroke_level] [int] NULL DEFAULT ((2)),
	[humidity_level] [int] NULL DEFAULT ((2)),
	[mold_mites_level] [int] NULL DEFAULT ((2)),
	[illuminance_daytime_level] [int] NULL DEFAULT ((2)),
	[illuminance_night_level] [int] NULL DEFAULT ((2)),
	[disconnection_level] [int] NULL DEFAULT ((2)),
	[wake_up_level] [int] NULL DEFAULT ((2)),
	[sleep_level] [int] NULL DEFAULT ((2)),
	[abnormal_behavior_level] [int] NULL DEFAULT ((2)),
	[active_non_detection_level] [int] NULL DEFAULT ((2)),
	[active_night_level] [int] NULL DEFAULT ((2)),
	[enable] [int] NULL DEFAULT ((1)),
	[shipping_date] [date] NULL,
	[serial] [nvarchar](50) NULL,
	[type] [nvarchar](45) NULL,
	[cold_level] [int] NULL DEFAULT ((2)),
 CONSTRAINT [PK_sensor_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON),
 CONSTRAINT [UNQ_sensors_001] UNIQUE NONCLUSTERED 
(
	[name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Table [dbo].[tmp_bedsensor]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tmp_bedsensor](
	[sensor_id] [nvarchar](450) NULL,
	[active] [float] NULL,
	[humidity] [float] NULL,
	[illuminance] [float] NULL,
	[temperature] [float] NULL,
	[humans] [float] NULL,
	[motion] [float] NULL,
	[posture] [float] NULL,
	[sleep] [float] NULL,
	[rolling] [float] NULL,
	[pulse] [float] NULL,
	[date] [nvarchar](450) NULL,
	[__createdAt] [datetimeoffset](7) NOT NULL CONSTRAINT [DF_data___createdAt]  DEFAULT (CONVERT([datetimeoffset](3),sysutcdatetime(),(0)))
)

GO
/****** Object:  Table [dbo].[user_clients]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[user_clients](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NOT NULL,
	[client_user_id] [int] NOT NULL,
	[admin] [int] NULL DEFAULT ((0)),
 CONSTRAINT [PK_user_client_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON),
 CONSTRAINT [UNQ_user_clients_001] UNIQUE NONCLUSTERED 
(
	[user_id] ASC,
	[client_user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Table [dbo].[user_sensors]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[user_sensors](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NOT NULL,
	[sensor_id] [int] NOT NULL,
	[fire_alert] [int] NULL DEFAULT ((1)),
	[heatstroke_alert] [int] NULL DEFAULT ((1)),
	[hypothermia_alert] [int] NULL DEFAULT ((1)),
	[humidity_alert] [int] NULL DEFAULT ((1)),
	[mold_mites_alert] [int] NULL DEFAULT ((1)),
	[illuminance_daytime_alert] [int] NULL DEFAULT ((1)),
	[illuminance_night_alert] [int] NULL DEFAULT ((1)),
	[disconnection_alert] [int] NULL DEFAULT ((1)),
	[reconnection_alert] [int] NULL DEFAULT ((1)),
	[wake_up_alert] [int] NULL DEFAULT ((1)),
	[abnormal_behavior_alert] [int] NULL DEFAULT ((1)),
	[active_non_detection_alert] [int] NULL DEFAULT ((1)),
	[temperature_alert] [int] NULL DEFAULT ((1)),
	[sleep_alert] [int] NULL DEFAULT ((2)),
	[active_night_alert] [int] NULL DEFAULT ((1)),
	[snooze_interval] [int] NULL DEFAULT ((60)),
	[snooze_times] [int] NULL DEFAULT ((5)),
	[admin] [int] NULL DEFAULT ((0)),
	[cold_alert] [int] NULL DEFAULT ((1)),
 CONSTRAINT [PK_user_sensor_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON),
 CONSTRAINT [UNQ_user_sensors_001] UNIQUE NONCLUSTERED 
(
	[user_id] ASC,
	[sensor_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Table [dbo].[users]    Script Date: 4/24/2017 1:12:31 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[users](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[username] [nvarchar](50) NULL,
	[password] [nvarchar](255) NULL,
	[name] [nvarchar](50) NULL,
	[kana] [nvarchar](512) NULL,
	[email] [nvarchar](512) NULL,
	[profile_fields] [nvarchar](512) NULL,
	[last_login] [nvarchar](512) NULL,
	[login_hash] [nvarchar](512) NULL,
	[gender] [nchar](1) NULL,
	[phone] [nvarchar](512) NULL,
	[cellular] [nvarchar](255) NULL,
	[work_start_date] [date] NULL,
	[memo] [ntext] NULL,
	[admin] [int] NULL DEFAULT ((0)),
	[zip_code] [nvarchar](255) NULL,
	[prefecture] [nvarchar](255) NULL,
	[address] [ntext] NULL,
	[area] [nvarchar](255) NULL,
	[blood_type] [nvarchar](255) NULL,
	[birthday] [date] NULL,
	[emergency_name_1] [nvarchar](50) NULL,
	[emergency_phone_1] [nvarchar](50) NULL,
	[emergency_cellular_1] [nvarchar](50) NULL,
	[emergency_name_2] [nvarchar](50) NULL,
	[emergency_phone_2] [nvarchar](50) NULL,
	[emergency_cellular_2] [nvarchar](50) NULL,
	[profile_image] [nvarchar](255) NULL,
	[created_at] [int] NULL,
	[temperature_alert] [int] NULL,
	[fire_alert] [int] NULL,
	[heatstroke_alert] [int] NULL,
	[hypothermia_alert] [int] NULL,
	[humidity_alert] [int] NULL,
	[mold_mites_alert] [int] NULL,
	[illuminance_daytime_alert] [int] NULL,
	[illuminance_night_alert] [int] NULL,
	[disconnection_alert] [int] NULL,
	[reconnection_alert] [int] NULL,
	[wake_up_alert] [int] NULL,
	[abnormal_behavior_alert] [int] NULL,
	[active_non_detection_alert] [int] NULL,
	[subscription] [int] NULL DEFAULT ((1)),
	[updated_at] [int] NULL,
	[first_name] [nvarchar](45) NULL,
	[last_name] [nvarchar](45) NULL,
	[first_kana] [nvarchar](45) NULL,
	[last_kana] [nvarchar](45) NULL,
	[emergency_first_name_1] [nvarchar](45) NULL,
	[emergency_last_name_1] [nvarchar](45) NULL,
	[emergency_first_kana_1] [nvarchar](45) NULL,
	[emergency_last_kana_1] [nvarchar](45) NULL,
	[emergency_first_name_2] [nvarchar](45) NULL,
	[emergency_last_name_2] [nvarchar](45) NULL,
	[emergency_first_kana_2] [nvarchar](45) NULL,
	[emergency_last_kana_2] [nvarchar](45) NULL,
	[email_confirm] [int] NULL DEFAULT ((0)),
	[new_email] [nvarchar](512) NULL,
	[email_confirm_token] [nvarchar](50) NULL,
	[email_confirm_expired] [datetime] NULL,
	[master] [int] NULL DEFAULT ((0)),
	[affiliate] [nvarchar](45) NULL,
 CONSTRAINT [PK_user_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON),
 CONSTRAINT [UNQ_users_001] UNIQUE NONCLUSTERED 
(
	[email] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
)

GO
/****** Object:  Index [alerts]    Script Date: 4/24/2017 1:12:32 AM ******/
CREATE NONCLUSTERED INDEX [alerts] ON [dbo].[alerts]
(
	[sensor_id] ASC,
	[confirm_status] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
GO
/****** Object:  Index [IDX_alerts_001]    Script Date: 4/24/2017 1:12:32 AM ******/
CREATE NONCLUSTERED INDEX [IDX_alerts_001] ON [dbo].[alerts]
(
	[sensor_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
GO
/****** Object:  Index [contract_payment_id]    Script Date: 4/24/2017 1:12:32 AM ******/
CREATE UNIQUE NONCLUSTERED INDEX [contract_payment_id] ON [dbo].[contract_payments]
(
	[contract_id] ASC,
	[payment_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
GO
/****** Object:  Index [contract_sensor_id]    Script Date: 4/24/2017 1:12:32 AM ******/
CREATE UNIQUE NONCLUSTERED INDEX [contract_sensor_id] ON [dbo].[contract_sensors]
(
	[contract_id] ASC,
	[sensor_Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
GO
/****** Object:  Index [data_daily]    Script Date: 4/24/2017 1:12:32 AM ******/
CREATE NONCLUSTERED INDEX [data_daily] ON [dbo].[data_daily]
(
	[sensor_id] ASC,
	[date] DESC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
GO
/****** Object:  Index [plan_option_id]    Script Date: 4/24/2017 1:12:32 AM ******/
CREATE UNIQUE NONCLUSTERED INDEX [plan_option_id] ON [dbo].[plan_options]
(
	[plan_id] ASC,
	[option_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
GO
SET ANSI_PADDING ON

GO
/****** Object:  Index [sensor_name]    Script Date: 4/24/2017 1:12:32 AM ******/
CREATE UNIQUE NONCLUSTERED INDEX [sensor_name] ON [dbo].[sensors]
(
	[name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
GO
/****** Object:  Index [user_clients]    Script Date: 4/24/2017 1:12:32 AM ******/
CREATE UNIQUE NONCLUSTERED INDEX [user_clients] ON [dbo].[user_clients]
(
	[user_id] ASC,
	[client_user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
GO
/****** Object:  Index [user_sensors]    Script Date: 4/24/2017 1:12:32 AM ******/
CREATE UNIQUE NONCLUSTERED INDEX [user_sensors] ON [dbo].[user_sensors]
(
	[user_id] ASC,
	[sensor_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)
GO
USE [master]
GO
ALTER DATABASE [infic_test] SET  READ_WRITE 
GO

