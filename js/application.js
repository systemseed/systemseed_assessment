'use strict';
// Get React hook from the global object.
// See more info on hooks if needed https://reactjs.org/docs/hooks-intro.html.
const { useState } = React;
// Grab html placeholder from field formatter output.
const rootElement = document.getElementById('todo-list');
// Get json data with field content from Drupal.
const todoList = JSON.parse(rootElement.dataset.todoList) || [];

// This is JSX Component for the whole To-Do List application.
const Application = () => {
  // React hooks to handle the original state of To-Do List as well as to
  // manage changes of its state.
  const [todoItems, setTodoItems] = useState(todoList);

  // React to the change of the checkbox of a To-Do item.
  // WE EXPECT YOU TO PUT THE CODE WHICH SAVES THE STATE
  // INSIDE THIS METHOD.
  const onItemChange = (event) => {
    // Get value of the paragraph ID from the triggered element.
    const id = Number.parseInt(event.target.value, 10);
    // Get index of the element in the list of To-Do items.
    const itemIndex = todoItems.findIndex(todoItem => todoItem.id === id);
    // Deep clone the array to make sure that we don't drag our changes
    // to the mutable array with state.
    const newTodoItems = [...todoItems];
    newTodoItems[itemIndex].completed = event.target.checked;
    setTodoItems(newTodoItems);
  };

  return (
    <div className="todo-list">
      {todoList.map(item => {
        return (
          <div className="todo-list__item" key={item.id}>
            <input
              type="checkbox"
              value={item.id}
              id={"item-" + item.id}
              name={"item-" + item.id}
              className="todo-list__input"
              checked={todoItems.find(todoItem => todoItem.id === item.id).completed}
              onChange={onItemChange}
            />
            <label
              htmlFor={"item-" + item.id}
              className="todo-list__item-label"
              dangerouslySetInnerHTML={{ __html: item.label }}
            />
          </div>
        );
      })}
    </div>
  );
};

// Render react component inside the field's html.
const root = ReactDOM.createRoot(rootElement);
root.render(<Application />);
