create table if not exists SRS_REPORT (
rid int primary key auto_increment,
reporter varchar(100) not null default "Anonymouse",
email varchar(100),
location varchar(150) not null default "-",
status set("Unresolved", "Pending", "Resolved"),
description varchar(255) null default "No Description Provided"
);

create table if not exists SRS_COMMENT(
cid int primary key auto_increment,
rid int,
name varchar(150) default "Unknown",
comment varchar(255) not null,
	FOREIGN KEY (rid) references SRS_REPORT(rid)
)