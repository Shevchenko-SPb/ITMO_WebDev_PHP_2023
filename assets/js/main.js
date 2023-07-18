import DOM from './dom.js';


const KEY_LOCAL_TASKS = 'tasks';

  const Tags = ['Web', 'Update', 'Design', 'Content'];

  class TaskVO {
    static fromJSON(json) {
      return new TaskVO(json.id, json.title, json.body, json.dt_end, json.tag, json.priority);
    }

    constructor(id, title, body, date, tag, priority) {
      this.id = id;
      this.title = title;
      this.body = body;
      this.dt_end = date;
      this.tag = tag;
      this.priority = priority;
    }
  }

  const getDOM = (id) => document.getElementById(id);
  const QUERY = (container, id) => container.querySelector(`[data-id="${id}"]`);

  const domTemplateTask = getDOM(DOM.Template.TASK);
  const domBtnTagFilter = getDOM(DOM.Template.Main.TAG_FILTER)
  const domBtnDateFilter = getDOM(DOM.Template.Main.DATE_FILTER)



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

const mapTags = new Map([
]);



getTasks ()
function getTasks () {
  axios.get('/tasks', {
    headers: headers
  })
      .then(function (response) {
        rawTasks = response.data.result
        for (let key in rawTasks) {
          mapTags.set(rawTasks[key][0], rawTasks[key][2])
        }


        const tasks = rawTasks
        // console.log(tasks.sort((a, b) => a.distance - b.distance))


            ? rawTasks.map((json) => TaskVO.fromJSON(json))
            : [];
        console.log(tasks)



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
}


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


domBtnTagFilter.addEventListener('change', function (e) {
  console.log('worked1')
  mapTags.forEach((value, key) => {
    if (true) {
      getDOM(key).classList.remove('hidden')
    }
  })

  mapTags.forEach((value, key) => {
    if (!(value === domBtnTagFilter.value)) {
      getDOM(key).classList.add('hidden')
    }
  })

  mapTags.forEach((value, key) => {
    if ('Reset' === domBtnTagFilter.value) {
      getDOM(key).classList.remove('hidden')
    }
  })
})

domBtnDateFilter.addEventListener('change', function (e) {
  mapTags.forEach((value, key) => {
    if (true) {
      getDOM(key).classList.add('hidden')
    }
  })

  const tasks = rawTasks
      ? rawTasks.map((json) => TaskVO.fromJSON(json))
      : [];

  if ('Deadline' === domBtnDateFilter.value) {
    console.log(tasks.sort((x, y) => y.dt_end.localeCompare(x.dt_end)));
    tasks.forEach((taskVO) => renderTask(taskVO));
  } else if ('NewTasks' === domBtnDateFilter.value) {
    console.log(tasks.sort((x, y) => x.dt_end.localeCompare(y.dt_end)));
    tasks.forEach((taskVO) => renderTask(taskVO));
  } else {
    tasks.forEach((taskVO) => renderTask(taskVO));
  }
})





  const taskOperations = {
    [DOM.Template.Task.BTN_DELETE]: (taskVO, domTask) => {
      renderTaskPopup(
          taskVO,
          'Confirm delete task?',
          'Delete',
          (taskTitle, taskBody, taskDate, taskTag, taskPriority) => {
            console.log('> Delete task -> On Confirm', {
              taskTitle,
              taskBody,
              taskDate,
              taskTag,
              taskPriority,
            });
            domTaskColumn.removeChild(domTask);
            deleteTask(taskVO);
          }
      );
    },
    [DOM.Template.Task.BTN_EDIT]: (taskVO, domTask) => {
      console.log(taskVO)

      renderTaskPopup(
        taskVO,
        'Update task',
        'Update',
        (taskTitle, taskBody, taskDate, taskTag, taskPriority,) => {
          taskVO.title = taskTitle;
          taskVO.body = taskBody;
          taskVO.dt_end = taskDate;
          taskVO.tag = taskTag;
          taskVO.priority = taskPriority;

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
    console.log(taskVO)


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
      (taskTitle, taskBody, taskDate, taskTag, taskPriority) => {
        const taskId = `task_${Date.now()}`;
        const taskVO = new TaskVO(taskId, taskTitle, taskBody, taskDate, taskTag, taskPriority);


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
    domTaskClone.setAttribute('id', taskVO.id)
    domTaskClone.dataset.id = taskVO.id;

    QUERY(domTaskClone, DOM.Template.Task.TITLE).innerText = taskVO.title;
    QUERY(domTaskClone, DOM.Template.Task.BODY).innerText = taskVO.body;
    QUERY(domTaskClone, DOM.Template.Task.TAG).innerText = taskVO.tag;
    QUERY(domTaskClone, DOM.Template.Task.DATE).innerText = counterDaysLeft(taskVO.dt_end)
    templateColorIconClock (domTaskClone, counterDaysLeft(taskVO.dt_end))

    // switch(parseInt(taskVO.tag)) {
    //   case 1:
    //     QUERY(domTaskClone, DOM.Template.Task.TAG).innerText = "Design";
    //     break;
    //   case 2:
    //     QUERY(domTaskClone, DOM.Template.Task.TAG).innerText = "Web";
    //     break;
    //   case 3:
    //     QUERY(domTaskClone, DOM.Template.Task.TAG).innerText = "Front";
    //     break;
    //   case 4:
    //     QUERY(domTaskClone, DOM.Template.Task.TAG).innerText = "Back";
    //     break;
    // };
    // switch(parseInt(taskVO.priority)) {
    //   case 1:
    //     QUERY(domTaskClone, DOM.Template.Task.PRIORITY).classList.add('text-red-500');
    //     break;
    //   case 2:
    //     QUERY(domTaskClone, DOM.Template.Task.PRIORITY).classList.add('text-orange-400');
    //     break;
    //   case 3:
    //     QUERY(domTaskClone, DOM.Template.Task.PRIORITY).classList.add('text-yellow-300');
    //     break;
    //   case 4:
    //     QUERY(domTaskClone, DOM.Template.Task.PRIORITY).classList.add('text-emerald-500');
    //     break;
    // };

    domTaskColumn.prepend(domTaskClone);
    return domTaskClone;
  }

  function templateColorIconClock (domTaskClone, daysLeft) {
    if (2 < daysLeft && daysLeft < 6) {
      QUERY(domTaskClone, DOM.Template.Task.ICON).classList.add('text-yellow-500');
    } else if (2 >= daysLeft) {
      QUERY(domTaskClone, DOM.Template.Task.ICON).classList.add('text-red-500');
    }
  }

  function counterDaysLeft (deadline) {
    const endDate = new Date(deadline)
    const currentDate = new Date().toISOString().slice(0, 10);
    const todayDate = new Date(currentDate)
    return Math.trunc((endDate.getTime() - todayDate.getTime()) / 86400000);
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
      (taskTitle, taskBody, taskDate, taskTags, taskPriority) => {
        processDataCallback(taskTitle, taskBody, taskDate, taskTags, taskPriority);
        onClosePopup();
      },
      onClosePopup
    );

    if (taskVO) {
      taskPopupInstance.taskTitle = taskVO.title;
      taskPopupInstance.taskBody = taskVO.body;
      taskPopupInstance.taskDate = taskVO.dt_end;
      taskPopupInstance.taskTags = taskVO.tag;
      taskPopupInstance.taskPriority = taskVO.priority;
    }

    document.onkeyup = (e) => {
      if (e.key === 'Escape') {
        onClosePopup();
      }
    };
    domPopupContainer.append(taskPopupInstance.render());
  }



  function saveTask(taskVO) {
    let $title = taskVO.title;
    let $body = taskVO.body;
    let $date = taskVO.dt_end;
    let $tag = taskVO.tag;
    let $priority = taskVO.priority;
    let $taskVOdata;
    $taskVOdata = [$title, $body, $date, $tag, $priority]
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

  let $title = taskVO.title;
  let $body = taskVO.body;
  let $id = taskVO.id;
  let $date = taskVO.dt_end;
  let $tag = taskVO.tag;
  let $priority = taskVO.priority;

  let $taskVOdata;
  $taskVOdata = [$title, $body, $id, $date, $tag, $priority]
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

