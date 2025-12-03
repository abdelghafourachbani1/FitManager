CREATE DATABASE gym;
USE gym;

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_nom VARCHAR(20) NOT NULL,
    categorie VARCHAR(20) NOT NULL,
    date_cours DATE NOT NULL,
    heure_cours TIME NOT NULL,
    duree TIME NOT NULL,     
    max_participant INT NOT NULL
);

INSERT INTO courses (course_nom, categorie, date_cours, heure_cours, duree, max_participant)
VALUES
('CrossFit Basics', 'Strength', '2025-12-05', '06:00:00', '01:00:00', 25),
('Yoga Flow', 'Flexibility', '2025-12-06', '07:00:00', '01:30:00', 20),
('Strength Training', 'Strength', '2025-12-07', '05:30:00', '01:15:00', 30);


CREATE TABLE equipements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipement_nom VARCHAR(20) NOT NULL,
    equipement_type VARCHAR(20) NOT NULL,
    equipement_quantite INT NOT NULL,
    equipement_etat VARCHAR(20) NOT NULL DEFAULT 'bon'
);


INSERT INTO equipements (equipement_nom, equipement_type, equipement_quantite, equipement_etat)
VALUES
('Dumbbells Set', 'Strength', 120, 'Good'),
('Treadmills', 'Cardio', 8, 'Medium'),
('Barbells', 'Strength', 24, 'To Replace'),
('Yoga Mats', 'Flexibility', 50, 'Good');


CREATE TABLE courses_equipements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cours_id INT,
    equipment_id INT,
    FOREIGN KEY (cours_id) REFERENCES courses(id),
    FOREIGN KEY (equipment_id) REFERENCES equipements(id)
);

INSERT INTO courses_equipements (cours_id, equipment_id)
VALUES
(1, 1),  
(1, 3),  
(2, 4), 
(3, 1),  
(3, 3);  

