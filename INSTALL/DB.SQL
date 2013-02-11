CREATE TABLE entry (
  id int(32) UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  datetime datetime NOT NULL,
  title varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  content text COLLATE utf8_unicode_ci,
  views int(32) UNSIGNED,
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE comment (
  id int(32) UNSIGNED NOT NULL AUTO_INCREMENT,
  pid int(32) UNSIGNED NOT NULL,
  datetime datetime NOT NULL,
  name varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  www varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  mail varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  content text NOT NULL,
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
