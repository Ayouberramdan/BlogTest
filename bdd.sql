CREATE TABLE post (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL ,
    slug VARCHAR (255) NOT NULL ,
    content TEXT(650000) NOT NULL ,
    created_at DATETIME NOT NULL ,
    PRIMARY KEY (id),
)