Enhance the existing Late Attendance input page by adding a dynamic student selection box that allows teachers to quickly add one or multiple students, search students easily, and enter late details individually per student.

This feature is designed to provide flexibility when students arrive late with different reasons or arrival times.

🧭 Updated User Flow

Teacher opens the Late Attendance page

A Student Selection Box is displayed

Teacher searches and selects students

Selected students appear in a Late Student List

Teacher fills late details per student

Teacher submits all records at once

1️⃣ Student Selection Box

Add a selection box with the following capabilities:

Displays all students from the selected class

Includes a search input (search by student name)

Allows selecting more than one student

Selected students are added to a list below the box

Prevents duplicate student selection

2️⃣ Late Student List (Editable)

For each selected student, display:

Student Name (read-only)

Class (read-only)

Late Reason (dropdown, editable per student)

Arrival Time (time picker, editable per student)

Late Date (date picker, default: current date)

Each student’s late data can be edited individually.

3️⃣ Final Submission Behavior

Teacher clicks Submit

System saves multiple late attendance records in one request

Each student’s late data is stored separately

Use database transactions to ensure data consistency

⚙️ System Rules

One student can only be added once per submission

Arrival time and reason are required per student

Default late date is the current date

Validation must be applied per student entry

🛠️ Technical Notes

Use dynamic form handling (JavaScript)

Use searchable dropdown (e.g., Select2 or custom search)

Batch insert late attendance records

Integrate seamlessly with existing Late Attendance logic