/**
 * CodeXpress Institute LMS — Mock Data & Auth
 * Shared across all LMS pages via window.CX
 */
(function(window) {
  'use strict';

  /* ── Demo Users ─────────────────────────────────────── */
  const USERS = [
    { id: 1, role: 'admin',   name: 'Admin Kumar',      email: 'admin@codexpress.edu',   password: 'admin123',   avatar: '../../dist/img/user2-160x160.jpg',  title: 'System Administrator' },
    { id: 2, role: 'teacher', name: 'Dr. Priya Sharma', email: 'teacher@codexpress.edu', password: 'teacher123', avatar: '../../dist/img/user3-128x128.jpg',  title: 'Senior Instructor' },
    { id: 3, role: 'student', name: 'Rahul Verma',      email: 'student@codexpress.edu', password: 'student123', avatar: '../../dist/img/user4-128x128.jpg',  title: 'Student — Full Stack Batch' },
    { id: 4, role: 'teacher', name: 'Mr. Arun Nair',    email: 'arun@codexpress.edu',    password: 'teacher123', avatar: '../../dist/img/user5-128x128.jpg',  title: 'Python & AI Instructor' },
    { id: 5, role: 'student', name: 'Anjali Singh',     email: 'anjali@codexpress.edu',  password: 'student123', avatar: '../../dist/img/user6-128x128.jpg',  title: 'Student — Data Science Batch' },
    { id: 6, role: 'student', name: 'Mohammed Farhan',  email: 'farhan@codexpress.edu',  password: 'student123', avatar: '../../dist/img/user7-128x128.jpg',  title: 'Student — Web Dev Batch' },
    { id: 7, role: 'student', name: 'Sneha Pillai',     email: 'sneha@codexpress.edu',   password: 'student123', avatar: '../../dist/img/user8-128x128.jpg',  title: 'Student — Full Stack Batch' },
  ];

  /* ── Courses ─────────────────────────────────────────── */
  const COURSES = [
    { id: 1, title: 'Full Stack Web Development with React & Node', category: 'Web Development', level: 'Intermediate', teacherId: 2, thumb: '../../dist/img/photo1.png', students: 142, lessons: 68, duration: '48h', rating: 4.8, price: 0, status: 'published', description: 'Master modern full stack development from frontend React to backend Node.js, Express and MongoDB.' },
    { id: 2, title: 'Python for Data Science & Machine Learning',   category: 'Data Science',    level: 'Beginner',     teacherId: 4, thumb: '../../dist/img/photo2.png', students: 98,  lessons: 52, duration: '36h', rating: 4.7, price: 0, status: 'published', description: 'Learn Python, NumPy, Pandas, Scikit-learn and build real ML models.' },
    { id: 3, title: 'UI/UX Design Fundamentals with Figma',         category: 'Design',          level: 'Beginner',     teacherId: 2, thumb: '../../dist/img/photo3.jpg', students: 76,  lessons: 38, duration: '24h', rating: 4.6, price: 0, status: 'published', description: 'Design beautiful interfaces and create interactive prototypes in Figma.' },
    { id: 4, title: 'Advanced JavaScript & TypeScript',             category: 'Web Development', level: 'Advanced',     teacherId: 2, thumb: '../../dist/img/photo4.jpg', students: 63,  lessons: 45, duration: '30h', rating: 4.9, price: 0, status: 'published', description: 'Deep dive into JavaScript internals, design patterns, and TypeScript.' },
    { id: 5, title: 'Android App Development with Kotlin',          category: 'Mobile Dev',      level: 'Intermediate', teacherId: 4, thumb: '../../dist/img/photo1.png', students: 54,  lessons: 42, duration: '32h', rating: 4.5, price: 0, status: 'draft',     description: 'Build production-ready Android apps using Kotlin and Jetpack Compose.' },
    { id: 6, title: 'DevOps & Cloud with AWS & Docker',             category: 'Cloud/DevOps',   level: 'Advanced',     teacherId: 4, thumb: '../../dist/img/photo2.png', students: 41,  lessons: 55, duration: '40h', rating: 4.7, price: 0, status: 'published', description: 'CI/CD pipelines, Docker, Kubernetes, and AWS cloud fundamentals.' },
  ];

  /* ── Curriculum for Course 1 ─────────────────────────── */
  const CURRICULUM = [
    { section: 'Section 1: HTML & CSS Fundamentals', lessons: [
      { id: 'l1', title: 'Introduction & Setup',         duration: '12:30', completed: true },
      { id: 'l2', title: 'HTML Structure & Semantics',   duration: '18:45', completed: true },
      { id: 'l3', title: 'CSS Selectors & Box Model',    duration: '22:10', completed: true },
      { id: 'l4', title: 'Flexbox & Grid Layout',        duration: '28:00', completed: false },
      { id: 'l5', title: 'Responsive Design Basics',     duration: '20:15', completed: false },
    ]},
    { section: 'Section 2: JavaScript Essentials', lessons: [
      { id: 'l6', title: 'Variables, Types & Functions', duration: '24:00', completed: false },
      { id: 'l7', title: 'DOM Manipulation',             duration: '30:20', completed: false },
      { id: 'l8', title: 'Async JS & Promises',          duration: '26:40', completed: false },
      { id: 'l9', title: 'ES6+ Modern Features',         duration: '22:50', completed: false },
    ]},
    { section: 'Section 3: React Framework', lessons: [
      { id: 'l10', title: 'React Components & JSX',     duration: '20:00', completed: false },
      { id: 'l11', title: 'State Management & Hooks',   duration: '35:00', completed: false },
      { id: 'l12', title: 'React Router & Navigation',  duration: '18:30', completed: false },
    ]},
    { section: 'Section 4: Node.js & Express', lessons: [
      { id: 'l13', title: 'Node.js Fundamentals',       duration: '22:00', completed: false },
      { id: 'l14', title: 'RESTful API Design',         duration: '28:00', completed: false },
      { id: 'l15', title: 'MongoDB & Mongoose',         duration: '32:00', completed: false },
    ]},
  ];

  /* ── Students ────────────────────────────────────────── */
  const STUDENTS = [
    { id: 3, name: 'Rahul Verma',     email: 'rahul@codexpress.edu',   avatar: '../../dist/img/user4-128x128.jpg', enrolledCourses: [1,2,3], progress: { 1: 44, 2: 72, 3: 15 }, gpa: 3.6, batch: 'Full Stack — Batch 12', joinDate: '2026-01-15', status: 'active' },
    { id: 5, name: 'Anjali Singh',    email: 'anjali@codexpress.edu',  avatar: '../../dist/img/user6-128x128.jpg', enrolledCourses: [2,4],   progress: { 2: 88, 4: 30 },        gpa: 3.9, batch: 'Data Science — Batch 8',  joinDate: '2026-02-01', status: 'active' },
    { id: 6, name: 'Mohammed Farhan', email: 'farhan@codexpress.edu',  avatar: '../../dist/img/user7-128x128.jpg', enrolledCourses: [1,6],   progress: { 1: 60, 6: 22 },        gpa: 3.2, batch: 'Web Dev — Batch 14',       joinDate: '2026-01-20', status: 'active' },
    { id: 7, name: 'Sneha Pillai',    email: 'sneha@codexpress.edu',   avatar: '../../dist/img/user8-128x128.jpg', enrolledCourses: [1,3,5], progress: { 1: 92, 3: 67, 5: 10 }, gpa: 4.0, batch: 'Full Stack — Batch 12',    joinDate: '2026-01-15', status: 'active' },
    { id: 8, name: 'Karthik Rajan',   email: 'karthik@codexpress.edu', avatar: '../../dist/img/user1-128x128.jpg', enrolledCourses: [2,4],   progress: { 2: 45, 4: 85 },        gpa: 3.5, batch: 'Data Science — Batch 8',  joinDate: '2026-03-10', status: 'active' },
    { id: 9, name: 'Divya Menon',     email: 'divya@codexpress.edu',   avatar: '../../dist/img/user2-160x160.jpg', enrolledCourses: [3,5,6], progress: { 3: 55, 5: 40, 6: 78 }, gpa: 3.7, batch: 'Mobile Dev — Batch 3',     joinDate: '2026-02-20', status: 'active' },
  ];

  /* ── Assignments ─────────────────────────────────────── */
  const ASSIGNMENTS = [
    { id: 1, courseId: 1, title: 'Build a Responsive Portfolio Website',   dueDate: '2026-07-15', maxScore: 100, type: 'project',    status: 'active'  },
    { id: 2, courseId: 1, title: 'JavaScript To-Do App',                   dueDate: '2026-07-10', maxScore: 100, type: 'project',    status: 'active'  },
    { id: 3, courseId: 2, title: 'Pandas Data Analysis Lab',               dueDate: '2026-07-12', maxScore: 50,  type: 'lab',        status: 'active'  },
    { id: 4, courseId: 2, title: 'ML Model — House Price Prediction',      dueDate: '2026-07-20', maxScore: 100, type: 'project',    status: 'active'  },
    { id: 5, courseId: 3, title: 'Design a Mobile App UI in Figma',        dueDate: '2026-07-08', maxScore: 100, type: 'design',     status: 'graded'  },
    { id: 6, courseId: 4, title: 'TypeScript REST API with Generics',      dueDate: '2026-07-18', maxScore: 100, type: 'project',    status: 'active'  },
  ];

  /* ── Student Submissions ─────────────────────────────── */
  const SUBMISSIONS = [
    { studentId: 3, assignmentId: 1, submittedAt: '2026-07-05', score: 88, feedback: 'Great layout and responsiveness. Improve accessibility.', status: 'graded' },
    { studentId: 3, assignmentId: 3, submittedAt: '2026-07-06', score: 42, feedback: 'Good analysis. Show more visualizations next time.',       status: 'graded' },
    { studentId: 3, assignmentId: 5, submittedAt: '2026-07-07', score: null, feedback: null, status: 'pending' },
    { studentId: 5, assignmentId: 3, submittedAt: '2026-07-04', score: 49, feedback: 'Excellent work! Perfect pandas usage.',                    status: 'graded' },
    { studentId: 7, assignmentId: 1, submittedAt: '2026-07-03', score: 96, feedback: 'Outstanding! Clean code and beautiful design.',            status: 'graded' },
  ];

  /* ── Quizzes ─────────────────────────────────────────── */
  const QUIZZES = [
    { id: 1, courseId: 1, title: 'HTML & CSS Basics Quiz', questions: 10, timeLimit: 15, passingScore: 60, attempts: 2 },
    { id: 2, courseId: 1, title: 'JavaScript Fundamentals Quiz', questions: 15, timeLimit: 20, passingScore: 65, attempts: 2 },
    { id: 3, courseId: 2, title: 'Python Syntax & Data Structures', questions: 12, timeLimit: 15, passingScore: 60, attempts: 3 },
  ];

  /* ── Quiz Questions (for quiz-take page) ─────────────── */
  const QUIZ_QUESTIONS = [
    { id: 1, question: 'Which HTML tag is used to define a navigation bar?', options: ['<nav>', '<header>', '<menu>', '<navbar>'], correct: 0, explanation: 'The <nav> element is specifically designed for navigation links.' },
    { id: 2, question: 'What does CSS stand for?', options: ['Computer Style Sheets', 'Cascading Style Sheets', 'Creative Style Syntax', 'Colorful Style Sheets'], correct: 1, explanation: 'CSS stands for Cascading Style Sheets.' },
    { id: 3, question: 'Which property in CSS is used to change the text color?', options: ['font-color', 'text-color', 'color', 'foreground'], correct: 2, explanation: 'The `color` property sets the text color.' },
    { id: 4, question: 'What is the correct way to write a JavaScript array?', options: ['var arr = (1, 2, 3)', 'var arr = [1, 2, 3]', 'var arr = {1, 2, 3}', 'var arr = "1, 2, 3"'], correct: 1, explanation: 'Arrays use square brackets [].' },
    { id: 5, question: 'Which method adds an item to the end of an array in JS?', options: ['push()', 'add()', 'append()', 'insert()'], correct: 0, explanation: 'Array.push() adds elements to the end.' },
    { id: 6, question: 'What does "responsive design" mean?', options: ['Design that responds to clicks', 'Design that adapts to different screen sizes', 'Fast-loading design', 'Interactive design'], correct: 1, explanation: 'Responsive design adapts layout to different screen sizes.' },
    { id: 7, question: 'Which CSS property controls the flex direction?', options: ['flex-align', 'flex-flow', 'flex-direction', 'flex-order'], correct: 2, explanation: 'flex-direction sets the main axis direction.' },
    { id: 8, question: 'What is the output of: typeof null?', options: ['"null"', '"undefined"', '"object"', '"boolean"'], correct: 2, explanation: 'typeof null returns "object" — a well-known JavaScript quirk.' },
    { id: 9, question: 'Which HTML attribute links a stylesheet?', options: ['src', 'href', 'rel', 'link'], correct: 1, explanation: 'href specifies the URL of the linked stylesheet.' },
    { id: 10, question: 'What is the default display value of a <div>?', options: ['inline', 'block', 'inline-block', 'flex'], correct: 1, explanation: '<div> is a block-level element by default.' },
  ];

  /* ── Announcements ───────────────────────────────────── */
  const ANNOUNCEMENTS = [
    { id: 1, title: 'New Batch Starting — Full Stack Development',    body: 'Batch 13 for Full Stack Web Development will begin on August 1st, 2026. Enrollment is open now.', date: '2026-07-06', target: 'all',      icon: '🚀', pinned: true },
    { id: 2, title: 'Holiday Notice — July 18th',                      body: 'The institute will be closed on July 18th, 2026 for a national holiday. Online sessions are suspended.', date: '2026-07-05', target: 'all',      icon: '🏖️', pinned: false },
    { id: 3, title: 'Grade Reports Available',                          body: 'Grade reports for June 2026 are now available. Please log in and check your grades section.',          date: '2026-07-04', target: 'students', icon: '📊', pinned: false },
    { id: 4, title: 'Faculty Training — July 20th',                    body: 'All teachers are requested to attend the annual faculty training session on July 20th at 10 AM.',     date: '2026-07-03', target: 'teachers', icon: '📚', pinned: false },
    { id: 5, title: 'System Maintenance — Sunday 2AM–4AM',             body: 'The LMS portal will undergo maintenance. Please save your work before Sunday midnight.',              date: '2026-07-02', target: 'all',      icon: '🔧', pinned: false },
  ];

  /* ── Monthly Enrollment Data ─────────────────────────── */
  const ENROLLMENT_DATA = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
    data:   [28, 45, 62, 58, 89, 104, 142],
  };

  /* ── Auth Helpers ────────────────────────────────────── */
  function getUser() {
    try { return JSON.parse(localStorage.getItem('cxUser')); } catch(e) { return null; }
  }

  function setUser(user) {
    localStorage.setItem('cxUser', JSON.stringify(user));
  }

  function logout() {
    localStorage.removeItem('cxUser');
    // Navigate to login from anywhere
    const depth = window.location.pathname.split('/lms/')[1] || '';
    const levels = depth.split('/').length - 1;
    const prefix = levels > 0 ? '../'.repeat(levels) : './';
    window.location.href = prefix + 'login.html';
  }

  function requireRole(role) {
    const user = getUser();
    if (!user) { redirectToLogin(); return null; }
    if (role && user.role !== role) { redirectToLogin(); return null; }
    return user;
  }

  function redirectToLogin() {
    const depth = (window.location.pathname.split('/lms/')[1] || '').split('/').length - 1;
    const prefix = depth > 0 ? '../'.repeat(depth) : './';
    window.location.href = prefix + 'login.html';
  }

  function login(email, password, role) {
    const user = USERS.find(u => u.email === email && u.password === password && u.role === role);
    return user || null;
  }

  function demoLogin(role) {
    const demos = { admin: 'admin@codexpress.edu', teacher: 'teacher@codexpress.edu', student: 'student@codexpress.edu' };
    const demos2 = { admin: 'admin123', teacher: 'teacher123', student: 'student123' };
    return login(demos[role], demos2[role], role);
  }

  /* ── Dashboard URL by role ───────────────────────────── */
  function dashboardUrl(role) {
    const m = { admin: 'admin/dashboard.html', teacher: 'teacher/dashboard.html', student: 'student/dashboard.html' };
    const depth = (window.location.pathname.split('/lms/')[1] || '').split('/').length - 1;
    const prefix = depth > 0 ? '../'.repeat(depth) : './';
    return prefix + m[role];
  }

  /* ── Render navbar user info ─────────────────────────── */
  function renderNavUser() {
    const user = getUser();
    if (!user) return;
    const img = document.querySelectorAll('.cx-nav-avatar');
    const names = document.querySelectorAll('.cx-nav-name');
    const roles = document.querySelectorAll('.cx-nav-role');
    img.forEach(el => el.src = user.avatar);
    names.forEach(el => el.textContent = user.name);
    roles.forEach(el => el.textContent = user.title);
  }

  /* ── Grade letter ────────────────────────────────────── */
  function gradeLetter(score, max) {
    const pct = (score / max) * 100;
    if (pct >= 90) return 'A';
    if (pct >= 80) return 'B';
    if (pct >= 70) return 'C';
    if (pct >= 60) return 'D';
    return 'F';
  }

  /* ── Format date ─────────────────────────────────────── */
  function fmtDate(str) {
    return new Date(str).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' });
  }

  /* ── Expose global ───────────────────────────────────── */
  window.CX = {
    USERS, COURSES, CURRICULUM, STUDENTS, ASSIGNMENTS,
    SUBMISSIONS, QUIZZES, QUIZ_QUESTIONS, ANNOUNCEMENTS, ENROLLMENT_DATA,
    auth: { getUser, setUser, logout, requireRole, login, demoLogin, dashboardUrl, renderNavUser },
    utils: { gradeLetter, fmtDate },
  };

})(window);
