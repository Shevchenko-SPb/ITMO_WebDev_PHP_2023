import DOM from './dom.js';


const KEY_LOCAL_TASKS = 'tasks';

  const Tags = ['Web', 'Update', 'Design', 'Content'];

  class TaskVO {
    static fromJSON(json) {
      return new TaskVO(json.id, json.title, json.body, json.dt_end, json.tag);
    }

    constructor(id, title, body, date, tag) {
      this.id = id;
      this.title = title;
      this.body = body;
      this.dt_end = date;
      this.tag = tag;
    }
  }

  const getDOM = (id) => document.getElementById(id);
  const QUERY = (container, id) => container.querySelector(`[data-id="${id}"]`);

  const domTemplateTask = getDOM(DOM.Template.TASK);

  const domTaskColumn = domTemplateTask.parentNode;
  domTemplateTask.removeAttribute('id');
  domTemplateTask.remove();

  // const rawTasks = localStorage.getItem(KEY_LOCAL_TASKS);
  var rawTasks = undefined;
  var tasks = undefined;
//document.addEventListener("DOMContentLoaded", function(event) {
  const headers = {
    'Content-Type': 'application/json'
  }

axios.get('/tasks', {
  headers: headers
})
  .then(function (response) {
    rawTasks = response.data.result
    // console.log('rawTasks',rawTasks)
    // console.log(JSON.parse(response.data.result));
    const tasks = rawTasks
    console.log(tasks)

      ? rawTasks.map((json) => TaskVO.fromJSON(json))
      : [];
    tasks.forEach((taskVO) => renderTask(taskVO));
    // console.log('tasks ->>>',tasks)

  })
  .catch(function (error) {
    // handle error
    //console.log(error);
  })
  .finally(function () {
    // always executed
  });

// console.log('Tasks ->>>>',tasks)
  //console.log('finish');
//});
//______________________Listner
//   const eventSource = new EventSource('http://localhost:8081/sse');
//   const listElement = document.getElementById('message-list');
//
//   eventSource.onmessage = function (currentEvent) {
//   // const newElement = document.createElement('li');
//   // newElement.innerText = currentEvent.data;
//
//   // listElement.appendChild(newElement)
//   console.log(currentEvent);
//   };
//________________________________


  // const tasks = rawTasks
  //   ? JSON.parse(rawTasks).map((json) => TaskVO.fromJSON(json))
  //   : [];
  // tasks.forEach((taskVO) => renderTask(taskVO));
//console.log('> tasks:', tasks);



  const taskOperations = {
    [DOM.Template.Task.BTN_DELETE]: (taskVO, domTask) => {
      renderTaskPopup(
          taskVO,
          'Confirm delete task?',
          'Delete',
          (taskTitle, taskBody, taskDate, taskTag) => {
            console.log('> Delete task -> On Confirm', {
              taskTitle,
              taskBody,
              taskDate,
              taskTag,
            });
            domTaskColumn.removeChild(domTask);
            deleteTask(taskVO);
          }
      );
    },
    [DOM.Template.Task.BTN_EDIT]: (taskVO, domTask) => {

      renderTaskPopup(
        taskVO,
        'Update task',
        'Update',
        (taskTitle, taskBody, taskDate, taskTag) => {
          taskVO.title = taskTitle;
          taskVO.body = taskBody;

          const domTaskUpdated = renderTask(taskVO);
          domTaskColumn.replaceChild(domTaskUpdated, domTask);
          updateTask(taskVO);
        }
      );
    },
  };

  domTaskColumn.onclick = (e) => {
    e.stopPropagation();
    const domTaskElement = e.target;
    const taskBtn = domTaskElement.dataset.btn;

    const isNotTaskBtn = !taskBtn;
    if (isNotTaskBtn) return;

    const allowedButtons = [
      DOM.Template.Task.BTN_EDIT,
      DOM.Template.Task.BTN_DELETE,
    ];
    if (!allowedButtons.includes(taskBtn)) return;

    let taskId;
    let domTask = domTaskElement;
    console.log('domTask ->', domTask)

    do {
      domTask = domTask.parentNode;
      taskId = domTask.dataset.id;
    } while (!taskId);

    console.log('rawTasks',rawTasks)
    const tasks = rawTasks
        ? rawTasks.map((json) => TaskVO.fromJSON(json))
        : [];

    const taskVO = tasks.find((task) => task.id == taskId);

    const taskOperation = taskOperations[taskBtn];
    if (taskOperation) {
      taskOperation(taskVO, domTask);
    }
  };
  function templatePopupCreateTask () {
    // console.log("hello")
    renderTaskPopup(
      null,
      'Create task',
      'Create',
      (taskTitle, taskBody, taskDate, taskTag) => {
        const taskId = `task_${Date.now()}`;
        const taskVO = new TaskVO(taskId, taskTitle, taskBody, taskDate, taskTag);

        renderTask(taskVO);
        // tasks.push(taskVO);

        saveTask(taskVO);
      }
    );
  }

  getDOM(DOM.Button.ADD_TASK).onclick = () => {
    templatePopupCreateTask ()
  }

  getDOM(DOM.Button.CREATE_TASK).onclick = () => {
    templatePopupCreateTask ()
  };


  function renderTask(taskVO) {

    const domTaskClone = domTemplateTask.cloneNode(true);

    domTaskClone.dataset.id = taskVO.id;

    QUERY(domTaskClone, DOM.Template.Task.TITLE).innerText = taskVO.title;
    QUERY(domTaskClone, DOM.Template.Task.BODY).innerText = taskVO.body;
    QUERY(domTaskClone, DOM.Template.Task.DATE).innerText = counterDaysLeft(taskVO.dt_end)

    domTaskColumn.prepend(domTaskClone);
    return domTaskClone;
  }

  function counterDaysLeft (deadline) {
    const endDate = new Date(deadline)
    console.log(deadline)
    const currentDate = new Date().getTime()
    return Math.trunc((endDate.getTime() - currentDate) / 86400000);
  }




  async function renderTaskPopup(
    taskVO,
    popupTitle,
    confirmText,
    processDataCallback
  ) {
    const domPopupContainer = getDOM(DOM.Popup.CONTAINER);
    const domSpinner = domPopupContainer.querySelector('.spinner');

    domPopupContainer.classList.remove('hidden');

    const onClosePopup = () => {
      domPopupContainer.children[0].remove();
      domPopupContainer.classList.add('hidden');
    };

    const TaskPopup = (await import('./TaskPopup.js')).default;
    const taskPopupInstance = new TaskPopup(
      popupTitle,
      Tags,
      confirmText,
      (taskTitle, taskBody, taskDate, taskTags) => {
        processDataCallback(taskTitle, taskBody, taskDate, taskTags);
        onClosePopup();
      },
      onClosePopup
    );

    if (taskVO) {
      taskPopupInstance.taskTitle = taskVO.title;
      taskPopupInstance.taskBody = taskVO.body;
    }

    // setTimeout(() => {
    // domSpinner.remove();
    document.onkeyup = (e) => {
      if (e.key === 'Escape') {
        onClosePopup();
      }
    };
    domPopupContainer.append(taskPopupInstance.render());
    // }, 1000);
  }

  function saveTask(taskVO) {
    var $title = taskVO.title;
    var $body = taskVO.body;
    var $date = taskVO.dt_end;
    let $taskVOdata;
    $taskVOdata = [$title, $body, $date]
    // console.log($taskVOdata)

    axios.post('/createnewtask',
      JSON.parse(JSON.stringify($taskVOdata))
    )
        .then(function (response) {
          console.log(response);
        })
        .catch(function (error) {
          console.log(error);
        });
  }

  function deleteTask (taskVO) {
    console.log('Работает', taskVO)
    var $taskID = taskVO.id;

    axios.post('/deleteusertask',
        JSON.parse(JSON.stringify($taskID))
    )
        .then(function (response) {
          console.log(response);
        })
        .catch(function (error) {
          console.log(error);
        });
  }
function updateTask (taskVO) {
  console.log('Работает', taskVO)

  var $title = taskVO.title;
  var $body = taskVO.body;
  var $id = taskVO.id;
  let $taskVOdata;
  $taskVOdata = [$title, $body, $id]
  console.log($taskVOdata)

  axios.post('/updatenewtask',
      JSON.parse(JSON.stringify($taskVOdata))
  )
      .then(function (response) {
        console.log(response);
      })
      .catch(function (error) {
        console.log(error);
      });
}