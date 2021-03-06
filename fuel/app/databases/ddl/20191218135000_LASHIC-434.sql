ALTER TABLE [dbo].[users] DROP COLUMN `temporary`;

ALTER TABLE [dbo].[payments] ADD first_name nvarchar(512) NULL, last_name nvarchar(512) NULL, first_kana nvarchar(512) NULL, last_kana nvarchar(512) NULL, phone nvarchar(512) NULL, email nvarchar(512) NULL, token nvarchar(512) NULL, member_id nvarchar(512) NULL;
ALTER TABLE [dbo].[payments] ALTER COLUMN user_id int null;

ALTER TABLE [dbo].[contracts] ALTER COLUMN user_id int null;

CREATE NONCLUSTERED INDEX idx_payments_token ON [dbo].[payments](token) INCLUDE (first_name, last_name, first_kana, last_kana, phone, email);
CREATE NONCLUSTERED INDEX idx_payments_member_id ON [dbo].[payments](member_id) INCLUDE (first_name, last_name, first_kana, last_kana, phone, email);