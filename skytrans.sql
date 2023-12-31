USE [master]
GO
/****** Object:  Database [skytrans]    Script Date: 30/09/2023 20:51:28 ******/
CREATE DATABASE [skytrans]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'skytrans', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.SQLEXPRESS\MSSQL\DATA\skytrans.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'skytrans_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.SQLEXPRESS\MSSQL\DATA\skytrans_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
GO
ALTER DATABASE [skytrans] SET COMPATIBILITY_LEVEL = 140
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [skytrans].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [skytrans] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [skytrans] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [skytrans] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [skytrans] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [skytrans] SET ARITHABORT OFF 
GO
ALTER DATABASE [skytrans] SET AUTO_CLOSE ON 
GO
ALTER DATABASE [skytrans] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [skytrans] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [skytrans] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [skytrans] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [skytrans] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [skytrans] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [skytrans] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [skytrans] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [skytrans] SET  ENABLE_BROKER 
GO
ALTER DATABASE [skytrans] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [skytrans] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [skytrans] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [skytrans] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [skytrans] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [skytrans] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [skytrans] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [skytrans] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [skytrans] SET  MULTI_USER 
GO
ALTER DATABASE [skytrans] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [skytrans] SET DB_CHAINING OFF 
GO
ALTER DATABASE [skytrans] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [skytrans] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [skytrans] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [skytrans] SET QUERY_STORE = OFF
GO
USE [skytrans]
GO
/****** Object:  User [skytrans]    Script Date: 30/09/2023 20:51:28 ******/
CREATE USER [skytrans] FOR LOGIN [skytrans] WITH DEFAULT_SCHEMA=[dbo]
GO
ALTER ROLE [db_owner] ADD MEMBER [skytrans]
GO
/****** Object:  Table [dbo].[companies]    Script Date: 30/09/2023 20:51:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[companies](
	[id] [uniqueidentifier] NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[address] [nvarchar](max) NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
 CONSTRAINT [companies_id_primary] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[company_materials]    Script Date: 30/09/2023 20:51:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[company_materials](
	[id] [uniqueidentifier] NOT NULL,
	[company_id] [uniqueidentifier] NOT NULL,
	[material_id] [uniqueidentifier] NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
 CONSTRAINT [company_materials_id_primary] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[deliveries]    Script Date: 30/09/2023 20:51:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[deliveries](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[no] [nvarchar](255) NOT NULL,
	[company_id] [uniqueidentifier] NOT NULL,
	[company_name] [nvarchar](255) NOT NULL,
	[material_code] [nvarchar](255) NOT NULL,
	[material_name] [nvarchar](255) NOT NULL,
	[vehicle_plat_number] [nvarchar](255) NOT NULL,
	[vehicle_type] [nvarchar](255) NOT NULL,
	[vehicle_max_capacity] [nvarchar](255) NOT NULL,
	[driver_name] [nvarchar](255) NOT NULL,
	[driver_contact] [nvarchar](255) NOT NULL,
	[qr_code] [nvarchar](255) NULL,
	[date] [date] NOT NULL,
	[status] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[driver_changes]    Script Date: 30/09/2023 20:51:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[driver_changes](
	[id] [uniqueidentifier] NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[contact] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
 CONSTRAINT [driver_changes_id_primary] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[drivers]    Script Date: 30/09/2023 20:51:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[drivers](
	[id] [uniqueidentifier] NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[contact] [nvarchar](255) NOT NULL,
	[company_id] [uniqueidentifier] NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
 CONSTRAINT [drivers_id_primary] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[material_changes]    Script Date: 30/09/2023 20:51:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[material_changes](
	[id] [uniqueidentifier] NOT NULL,
	[material_id] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
 CONSTRAINT [material_changes_id_primary] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[materials]    Script Date: 30/09/2023 20:51:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[materials](
	[id] [uniqueidentifier] NOT NULL,
	[code] [nvarchar](255) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
 CONSTRAINT [materials_id_primary] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[migrations]    Script Date: 30/09/2023 20:51:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[migrations](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[migration] [nvarchar](255) NOT NULL,
	[batch] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[notifications]    Script Date: 30/09/2023 20:51:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[notifications](
	[id] [uniqueidentifier] NOT NULL,
	[user_id] [uniqueidentifier] NOT NULL,
	[title] [nvarchar](255) NOT NULL,
	[description] [nvarchar](max) NOT NULL,
	[icon] [nvarchar](255) NOT NULL,
	[color] [nvarchar](255) NOT NULL,
	[link] [nvarchar](255) NOT NULL,
	[is_read] [bit] NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
 CONSTRAINT [notifications_id_primary] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[personal_access_tokens]    Script Date: 30/09/2023 20:51:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[personal_access_tokens](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[tokenable_type] [nvarchar](255) NOT NULL,
	[tokenable_id] [bigint] NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[token] [nvarchar](64) NOT NULL,
	[abilities] [nvarchar](max) NULL,
	[last_used_at] [datetime] NULL,
	[expires_at] [datetime] NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[request_changes]    Script Date: 30/09/2023 20:51:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[request_changes](
	[id] [uniqueidentifier] NOT NULL,
	[user_id] [uniqueidentifier] NOT NULL,
	[action] [nvarchar](255) NOT NULL,
	[data] [nvarchar](255) NOT NULL,
	[data_id] [nvarchar](255) NOT NULL,
	[data_before_id] [nvarchar](255) NOT NULL,
	[data_change_id] [nvarchar](255) NULL,
	[status] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
 CONSTRAINT [request_changes_id_primary] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[users]    Script Date: 30/09/2023 20:51:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[users](
	[id] [uniqueidentifier] NOT NULL,
	[username] [nvarchar](255) NOT NULL,
	[password] [nvarchar](255) NOT NULL,
	[phone] [nvarchar](255) NULL,
	[company_id] [uniqueidentifier] NULL,
	[is_admin] [bit] NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
 CONSTRAINT [users_id_primary] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[vehicle_changes]    Script Date: 30/09/2023 20:51:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[vehicle_changes](
	[id] [uniqueidentifier] NOT NULL,
	[plat_number] [nvarchar](255) NOT NULL,
	[type] [nvarchar](255) NOT NULL,
	[max_capacity] [nvarchar](255) NOT NULL,
	[stnk] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
 CONSTRAINT [vehicle_changes_id_primary] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[vehicles]    Script Date: 30/09/2023 20:51:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[vehicles](
	[id] [uniqueidentifier] NOT NULL,
	[plat_number] [nvarchar](255) NOT NULL,
	[type] [nvarchar](255) NOT NULL,
	[max_capacity] [nvarchar](255) NOT NULL,
	[stnk] [nvarchar](255) NOT NULL,
	[company_id] [uniqueidentifier] NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
 CONSTRAINT [vehicles_id_primary] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [companies_name_unique]    Script Date: 30/09/2023 20:51:29 ******/
CREATE UNIQUE NONCLUSTERED INDEX [companies_name_unique] ON [dbo].[companies]
(
	[name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [materials_code_unique]    Script Date: 30/09/2023 20:51:29 ******/
CREATE UNIQUE NONCLUSTERED INDEX [materials_code_unique] ON [dbo].[materials]
(
	[code] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [personal_access_tokens_token_unique]    Script Date: 30/09/2023 20:51:29 ******/
CREATE UNIQUE NONCLUSTERED INDEX [personal_access_tokens_token_unique] ON [dbo].[personal_access_tokens]
(
	[token] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [personal_access_tokens_tokenable_type_tokenable_id_index]    Script Date: 30/09/2023 20:51:29 ******/
CREATE NONCLUSTERED INDEX [personal_access_tokens_tokenable_type_tokenable_id_index] ON [dbo].[personal_access_tokens]
(
	[tokenable_type] ASC,
	[tokenable_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[deliveries] ADD  DEFAULT ('Dikirim') FOR [status]
GO
ALTER TABLE [dbo].[notifications] ADD  DEFAULT ('0') FOR [is_read]
GO
ALTER TABLE [dbo].[request_changes] ADD  DEFAULT ('Pending') FOR [status]
GO
ALTER TABLE [dbo].[users] ADD  DEFAULT ('0') FOR [is_admin]
GO
ALTER TABLE [dbo].[deliveries]  WITH CHECK ADD CHECK  (([status]=N'Diterima' OR [status]=N'Dikirim'))
GO
ALTER TABLE [dbo].[request_changes]  WITH CHECK ADD CHECK  (([status]=N'Ditolak' OR [status]=N'Disetujui' OR [status]=N'Pending'))
GO
USE [master]
GO
ALTER DATABASE [skytrans] SET  READ_WRITE 
GO
