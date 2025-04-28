import React, { useState, useEffect } from 'react';
import { AiOutlineDelete } from 'react-icons/ai';
import { BsCheckLg } from 'react-icons/bs';
import axios from 'axios';
import './App.css';

const Index = () => {
  const [tasks, setTasks] = useState([]);
  const [newTitle, setNewTitle] = useState('');
  const [newDescription, setNewDescription] = useState('');
  const [isCompleteScreen, setIsCompleteScreen] = useState(false);
  const currentUser = window.user;

  useEffect(() => {
    fetchTasks();
  }, []);

  const fetchTasks = async () => {
    try {
      const response = await axios.get(`/employees/${currentUser.id}/tasks`);
      setTasks(response.data);
    } catch (error) {
      console.error('Erreur lors du chargement des tâches :', error);
    }
  };

  const addTask = async () => {
    if (!newTitle.trim() || !newDescription.trim()) return;

    try {
      const response = await axios.post('/tasks', {
        title: newTitle,
        description: newDescription,
        user_id: currentUser.id,
      });

      setTasks([...tasks, response.data]);
      setNewTitle('');
      setNewDescription('');
    } catch (error) {
      console.error("Erreur lors de l'ajout :", error);
    }
  };

  const markTaskCompleted = async (taskId) => {
    try {
      await axios.patch(`/tasks/${taskId}/complete`);
      fetchTasks(); // Recharge les tâches mises à jour
    } catch (error) {
      console.error('Erreur lors de la mise à jour :', error);
    }
  };
  
  
  const handleDeleteTask = async (taskId) => {
    try {
      await axios.delete(`/tasks/${taskId}`);
      setTasks(prev => prev.filter(task => task.id !== taskId));
    } catch (error) {
      console.error("Erreur lors de la suppression :", error);
    }
  };
  
  

  const todos = tasks.filter(t => !t.is_completed);
  const completed = tasks.filter(t => t.is_completed);

  return (
    <div className="todo-wrapper">
      <h1 className="main-title">My Todos</h1>

      <div className="todo-input">
        <div className="todo-input-item">
          <label>Title</label>
          <input
            type="text"
            value={newTitle}
            onChange={(e) => setNewTitle(e.target.value)}
              placeholder="What's the task Title?"
          />
        </div>

        <div className="todo-input-item">
          <label>Description</label>
          <input
            type="text"
            value={newDescription}
            onChange={(e) => setNewDescription(e.target.value)}
            placeholder="What's the task description?"
          />
        </div>

        <div className="todo-input-item">
          <button onClick={addTask} className="primaryBtn">Add</button>
        </div>
      </div>

      <div className="btn-area">
        <button
          className={`secondaryBtn ${!isCompleteScreen ? 'active' : ''}`}
          onClick={() => setIsCompleteScreen(false)}
        >
          Todo
        </button>
        <button
          className={`secondaryBtn ${isCompleteScreen ? 'active' : ''}`}
          onClick={() => setIsCompleteScreen(true)}
        >
          Completed
        </button>
      </div>

      <div className="todo-list">
        {!isCompleteScreen && todos.map((task) => (
          <div className="todo-list-item" key={task.id}>
            <div>
              <h3>{task.title}</h3>
              <p>{task.description}</p>
            </div>
            <div>
              <AiOutlineDelete
                className="icon"
                onClick={() => handleDeleteTask(task.id)}
                title="Delete"
              />
              <BsCheckLg
                className="check-icon"
                onClick={() => markTaskCompleted(task.id)}
                title="Complete"
              />
            </div>
          </div>
        ))}

        {isCompleteScreen && completed.map((task) => (
          <div className="todo-list-item" key={task.id}>
            <div>
              <h3>{task.title}</h3>
              <p>{task.description}</p>
            </div>
            <div>
              <AiOutlineDelete
                className="icon"
                onClick={() => handleDeleteTask(task.id)}
                title="Delete"
              />
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Index;
