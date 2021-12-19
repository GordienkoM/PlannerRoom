CREATE TABLE UserApp(
   id INT AUTO_INCREMENT,
   nickname VARCHAR(128) NOT NULL,
   email VARCHAR(128) NOT NULL,
   password VARCHAR(128) NOT NULL,
   code_change VARCHAR(8),
   role VARCHAR(10) NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(email)
);

CREATE TABLE Color(
   id INT AUTO_INCREMENT ,
   color_code VARCHAR(50) NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE TableApp(
   id INT AUTO_INCREMENT,
   title VARCHAR(255) NOT NULL,
   description TEXT,
   userApp_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(userApp_id) REFERENCES UserApp(id)
);

CREATE TABLE List(
   id INT AUTO_INCREMENT,
   title TEXT NOT NULL,
   tableApp_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(tableApp_id) REFERENCES TableApp(id)
);

CREATE TABLE Card(
   id INT AUTO_INCREMENT,
   list_position INT NOT NULL,
   content TEXT NOT NULL,
   label VARCHAR(255),
   list_id INT NOT NULL,
   color_id INT,
   PRIMARY KEY(id),
   FOREIGN KEY(list_id) REFERENCES List(id),
   FOREIGN KEY(color_id) REFERENCES Color(id)
);

CREATE TABLE Participation(
   tableApp_id INT,
   userApp_id INT,
   PRIMARY KEY(tableApp_id, userApp_id),
   FOREIGN KEY(tableApp_id) REFERENCES TableApp(id),
   FOREIGN KEY(userApp_id) REFERENCES UserApp(id)
);

CREATE TABLE Mark(
   card_id INT,
   userApp_id INT,
   PRIMARY KEY(card_id, userApp_id),
   FOREIGN KEY(card_id) REFERENCES Card(id),
   FOREIGN KEY(userApp_id) REFERENCES UserApp(id)
);

CREATE TABLE Invitation(
   tableApp_id INT,
   userApp_id INT,
   PRIMARY KEY(tableApp_id, userApp_id),
   FOREIGN KEY(tableApp_id) REFERENCES TableApp(id),
   FOREIGN KEY(userApp_id) REFERENCES UserApp(id)
);
