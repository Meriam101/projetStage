
import React, { useState, useEffect } from 'react';
import { AiOutlineDelete, AiOutlineEdit } from 'react-icons/ai';
import { BsCheckLg } from 'react-icons/bs';
import axios from 'axios';
import './App.css';

const Index = () => {
  const [tasks, setTasks] = useState([]);
  const [newTitle, setNewTitle] = useState('');
  const [newDescription, setNewDescription] = useState('');
  const [newDateFin, setNewDateFin] = useState('');
  const [isCompleteScreen, setIsCompleteScreen] = useState(false);
  const [editingTaskId, setEditingTaskId] = useState(null);
  const [editedTask, setEditedTask] = useState({ title: '', description: '' ,date_fin: ''});

  const currentUser = window.user;

  useEffect(() => {
    fetchTasks();
  }, []);

  const fetchTasks = async () => {
    try {
      const res = await axios.get(`/api/employees/${currentUser.id}/tasks`);
      setTasks(res.data);
    } catch (err) {
      console.error('Erreur lors du chargement :', err);
    }
  };

 
  const addTask = async () => {
    if (!newTitle.trim() || !newDescription.trim()) return;
  
    try {
      const res = await axios.post('/tasks', {
        title: newTitle,
        description: newDescription,
        date_fin: newDateFin,
        user_id: currentUser.id,
      });
  
      // Met à jour l'état des tâches avec la nouvelle tâche
      setTasks(prev => [...prev, res.data]);
  
      // Réinitialiser les champs
      setNewTitle('');
      setNewDescription('');
      setNewDateFin('');
    } catch (err) {
      console.error("Erreur d'ajout :", err);
    }
  };


  const deleteTask = async (taskId) => {
    try {
      await axios.delete(`/tasks/${taskId}`);
      setTasks(prev => prev.filter(t => t.id !== taskId));
    } catch (err) {
      console.error("Erreur suppression :", err);
    }
  };


  
  const markTaskCompleted = async (taskId) => {
    try {
      // Marque la tâche comme complétée côté backend
      const res = await axios.patch(`/tasks/${taskId}/complete`);
  
      // Met à jour l'état local après le changement
      setTasks(prev =>
        prev.map(task =>
          task.id === taskId ? { ...task, is_completed: true } : task
        )
      );
  
      // Vérifie si la tâche est correctement mise à jour dans l'UI
    } catch (err) {
      console.error("Erreur mise à jour :", err);
    }
  };
  

  const startEdit = (task) => {
    setEditingTaskId(task.id);
    setEditedTask({ title: task.title, description: task.description ,date_fin: task.date_fin });
  };

  const handleEditChange = (field, value) => {
    setEditedTask(prev => ({ ...prev, [field]: value }));
  };

  const saveEdit = async () => {
    try {
      await axios.put(`/tasks/${editingTaskId}`, editedTask);
      setEditingTaskId(null);
      setEditedTask({ title: '', description: '' });
      fetchTasks();
    } catch (err) {
      console.error("Erreur modification :", err);
    }
  };

  const todos = tasks.filter(task => !task.is_completed || task.is_completed === 0);
  const completed = tasks.filter(task => task.is_completed === true || task.is_completed === 1);
  

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
            placeholder="What's the task title?"
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
          <label>Date de fin</label>
          <input
          type="date"
          value={newDateFin}
          onChange={(e) => setNewDateFin(e.target.value)}
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
        {!isCompleteScreen &&
          todos.map((task) => (
            <div className="todo-list-item" key={task.id}>
              {editingTaskId === task.id ? (
                <div className="edit__wrapper">
                  <input
                    value={editedTask.title}
                    onChange={(e) => handleEditChange('title', e.target.value)}
                    placeholder="Updated Title"
                  />
                  <textarea
                    rows={3}
                    value={editedTask.description}
                    onChange={(e) => handleEditChange('description', e.target.value)}
                    placeholder="Updated Description"
                  />
                  <input
                  type="date"
                  value={editedTask.date_fin}
                  onChange={(e) => handleEditChange('date_fin', e.target.value)}
                />

                  <button onClick={saveEdit} className="primaryBtn">Update</button>
                </div>
              ) : (
                <>
                  <div>
                    <h3>{task.title}</h3>
                    <p>{task.description}</p>
                    <p>{task.date_fin}</p>

                  </div>
                  <div>
                    <AiOutlineDelete
                      className="icon"
                      onClick={() => deleteTask(task.id)}
                      title="Delete"
                    />
                    <BsCheckLg
                      className="check-icon"
                      onClick={() => markTaskCompleted(task.id)}
                      title="Complete"
                    />
                    <AiOutlineEdit
                      className="check-icon2"
                      onClick={() => startEdit(task)}
                      title="Edit"
                    />
                  </div>
                </>
              )}
            </div>
          ))}

        {isCompleteScreen &&
          completed.map((task) => (
            <div className="todo-list-item" key={task.id}>
              <div>
                <h3>{task.title}</h3>
                <p>{task.description}</p>
                <p>{task.date_fin}</p>
              </div>
              <div>
                <AiOutlineDelete
                  className="icon"
                  onClick={() => deleteTask(task.id)}
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