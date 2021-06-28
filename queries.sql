text1 = "CREATE TABLE formdata(
            id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            student_name VARCHAR(20) NOT NULL,
            father_name VARCHAR(20) NOT NULL,
            roll_number BIGINT(20) NOT NULL UNIQUE,
            emailid VARCHAR(20) NOT NULL,
            contact BIGINT(20) NOT NULL,
            department VARCHAR(20) NOT NULL,
            graduation VARCHAR(20) NOT NULL,
            course_duration INT(4) NOT NULL,
            course_type VARCHAR(20) NOT NULL,
            paddress TEXT NOT NULL,
            image_name VARCHAR(255) NOT NULL
        )"

text2 = "DROP TABLE formdata"

text3 = "SELECT * FROM formdata"

text4 = "SELECT student_name,emailid,department, FROM formdata WHERE roll_number = $roll_number"

text4 = "DELETE from formdata"