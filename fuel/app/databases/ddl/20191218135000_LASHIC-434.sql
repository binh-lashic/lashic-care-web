ALTER TABLE [dbo].[users] DROP COLUMN `temporary`;

ALTER TABLE [dbo].[contracts] ADD first_name nvarchar(512) NULL, last_name nvarchar(512) NULL, first_kana nvarchar(512) NULL, last_kana nvarchar(512) NULL, phone nvarchar(512) NULL, email nvarchar(512) NULL, token nvarchar(512) NULL;

ALTER TABLE [dbo].[contracts] ALTER COLUMN user_id int null;
ALTER TABLE [dbo].[contracts] ALTER COLUMN plan_id int null;