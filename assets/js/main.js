import DOM from './dom.js';
import Dom from "./dom.js";
import {randomString} from "./stringUtils.js";


const KEY_LOCAL_TASKS = 'tasks';

  const Tags = ['Web', 'Update', 'Design', 'Content'];

  class TaskVO {
    static fromJSON(json) {
      return new TaskVO(json.id, json.title, json.body, json.dt_end, json.tag, json.priority, json.id_status);
    }

    constructor(id, title, body, date, tag, priority, status) {
      this.id = id;
      this.title = title;
      this.body = body;
      this.dt_end = date;
      this.tag = tag;
      this.priority = priority;
      this.id_status = status;
    }
  }
  class DashboardVO {
    static fromJSON(json) {
      return new DashboardVO(json.id, json.dashboard_name, json.id_column1, json.name_column1, json.id_column2, json.name_column2, json.id_column3, json.name_column3, json.id_column4, json.name_column4, json.id_column5, json.name_column5, json.id_column6, json.name_column6, json.id_column7, json.name_column7, json.id_column8, json.name_column8, json.id_column9, json.name_column9, json.id_column10, json.name_column10)
    }
    constructor(id, dashboardName, idColumn1, nameColumn1, idColumn2, nameColumn2, idColumn3, nameColumn3, idColumn4, nameColumn4, idColumn5, nameColumn5, idColumn6, nameColumn6, idColumn7, nameColumn7, idColumn8, nameColumn8, idColumn9, nameColumn9, idColumn10, nameColumn10) {
      this.id = id;
      this.dashboard_name = dashboardName;
      this.id_column1 = idColumn1;
      this.name_column1 = nameColumn1;
      this.id_column2 = idColumn2;
      this.name_column2 = nameColumn2;
      this.id_column3 = idColumn3;
      this.name_column3 = nameColumn3;
      this.id_column4 = idColumn4;
      this.name_column4 = nameColumn4;
      this.id_column5 = idColumn5;
      this.name_column5 = nameColumn5;
      this.id_column6 = idColumn6;
      this.name_column6 = nameColumn6;
      this.id_column7 = idColumn7;
      this.name_column7 = nameColumn7;
      this.id_column8 = idColumn8;
      this.name_column8 = nameColumn8;
      this.id_column9 = idColumn9;
      this.name_column9 = nameColumn9;
      this.id_column10 = idColumn10;
      this.name_column10 = nameColumn10;
    }
  }
const dashboardVO = new DashboardVO();
  const getDOM = (id) => document.getElementById(id);
  const QUERY = (container, id) => container.querySelector(`[data-id="${id}"]`);

  const domTemplateTask = getDOM(DOM.Template.TASK)
  const domBtnShowFilter = getDOM(DOM.Button.SHOW_FILTERS)
  const domBtnTagFilter = getDOM(DOM.Button.TAG_FILTER)
  const domBtnDateFilter = getDOM(DOM.Button.DATE_FILTER)
  const domBtnCreateDashboard = getDOM(DOM.Button.CREATE_DASHBOARD)
  const domDashboard = getDOM(Dom.Template.DASHBOARD);
  const domDashboardTemplate = getDOM(Dom.Template.DASHBOARD_TEMPLATE);
  const domDashboardList = getDOM(Dom.Template.DASHBOARD_LIST);
  const domSafeDashboard = getDOM(Dom.Button.SAFE_DASHBOARD)
  const domDashboardName = getDOM(Dom.Template.DASHBOARD_NANE);
  const domDashboardCount = getDOM(Dom.Template.DASHBOARD_COUNT)
  const tagsArray = {'Design': 1, 'Web' : 2 , 'Front' : 3, 'Back': 4}

domTemplateTask.removeAttribute('id');
domTemplateTask.remove();

////////////////// Создание Dashboard////////////////////
const newDashboard = domDashboard.querySelector("div[id]").cloneNode(true);
const dashboardItem = QUERY(domDashboardList, 'dashboardItem');
const newDashboardItem = dashboardItem.cloneNode(true)
const dashboards = undefined;
const clone = getDOM('cloneColumn')
const cloneCol = clone.cloneNode(true)



domBtnCreateDashboard.onclick = () => {
  if (!domSafeDashboard.classList.contains("hidden")) {
    return
  }
  domDashboardTemplate.removeAttribute('id');
  domDashboardTemplate.remove();

  newDashboard.id = randomString(5) + Date.now();
  while (newDashboard.children.length > 1) {
    newDashboard.removeChild(newDashboard.lastChild);
  }
  newDashboard.appendChild(cloneCol)

  newDashboard.childNodes.forEach(element => element.id = newDashboard.id + "||" + randomString(5))
  domDashboard.appendChild(newDashboard);

  const newDashboardListName = QUERY(domDashboardList, 'dashboardInpName');
  newDashboardListName.classList.remove("hidden")
  let dashboardName;

  newDashboardListName.addEventListener('keyup', function (e) {

    dashboardName = newDashboardListName.querySelector("input").value;
    domDashboardName.innerText = dashboardName
    QUERY(newDashboardItem, "dashboardName").innerText = dashboardName
  })
  newDashboardItem.dataset.id = newDashboard.id
  domDashboardList.appendChild(newDashboardItem)
  domSafeDashboard.classList.remove("hidden")


  QUERY(domSafeDashboard, "confirm").onclick = () => {
    console.log(dashboardVO)
    dashboardVO.id = newDashboard.id;
    dashboardVO.dashboard_name = dashboardName;
    const columnsList = newDashboard.querySelectorAll(".column")

    columnsList.forEach(element => {
      for (var key in dashboardVO) {
        if(!(dashboardVO[key]) && key.indexOf('name_column')) {
          dashboardVO[key] = element.id
          return;
        }
      }
    })
    columnsList.forEach(element => {
      for (var key in dashboardVO) {
        if(!(dashboardVO[key]) && key.indexOf('id_column')) {
          dashboardVO[key] = QUERY(element, 'columnNameTemp').innerText
          return
        }
      }
    })
    console.log(dashboardVO)

    saveDashboard(dashboardVO);
    newDashboardItem.classList.remove("hidden");
    newDashboardListName.classList.add("hidden")
    domSafeDashboard.classList.add("hidden")
  }
  QUERY(domSafeDashboard, "cancel").onclick = () => {
    window.location.reload(true);
  }
}

domDashboard.addEventListener('click', function (e) {
  e.target.addEventListener('keyup', function (e) {
    const columnName = e.target.parentNode.querySelector(`[data-id="columnNameTemp"]`)
    columnName.innerText = e.target.value
        if (e.key === 'Enter') {
          e.target.classList.add('hidden')
          columnName.classList.remove('hidden')
        }
      }
  )

})

//////////////////Клонирование колонки///////////////////
function createNewColumn (elem) {
  let taskColumn = elem.closest(".column")
  let clone = taskColumn.cloneNode(true);
  let tasksArray = clone.querySelectorAll('div.task')
  for (let i = 0; i < tasksArray.length; i++) {
    tasksArray[i].remove();
  }
  clone.id = newDashboard.id + "||" + randomString(5);
  console.log(clone.id)
  if (taskColumn.parentNode.children.length === 9) {
    alert("Количество колонок не более 10")
    return
  }
  taskColumn.parentNode.insertBefore(clone, taskColumn.nextSibling);
}
//////////////////////////////////////////////////////////////

// const rawTasks = localStorage.getItem(KEY_LOCAL_TASKS);
  var rawTasks = undefined;
  var rawDashboards = undefined;
  var tasks = undefined;
//document.addEventListener("DOMContentLoaded", function(event) {
  const headers = {
    'Content-Type': 'application/json'
  }

const mapTags = new Map([
]);

getDashboards ()
  function getDashboards () {
    axios.get('/getListdashboards', {
      headers: headers
    })
        .then(function (response) {
          rawDashboards = response.data.result
          for (let key in rawDashboards) {
            mapTags.set(rawDashboards[key][0], rawDashboards[key][2])
          }
          const dashboards = rawDashboards
              ? rawDashboards.map((json) => DashboardVO.fromJSON(json))
              : [];
          console.log(dashboards)
          dashboards.forEach((dashboardVO) => renderDashboardList(dashboardVO));
        })
        .catch(function (error) {
        })
        .finally(function () {
        })
  }

  function countDashboards () {
  domDashboardCount.innerText = domDashboardList.childNodes.length - 5;
  }

function renderDashboardList (dashboardVO) {
  const newDashboardItem =   dashboardItem.cloneNode(true);
  newDashboardItem.setAttribute('data-id', dashboardVO.id)
  QUERY(newDashboardItem, 'dashboardName').innerText = dashboardVO.dashboard_name
  newDashboardItem.classList.remove("hidden")
  domDashboardList.appendChild(newDashboardItem)
  countDashboards ()

  QUERY(newDashboardItem, "dashboardName").onclick = (e) =>
  {
    templateDashboard (e)
  }
}
function templateDashboard (e) {
  const targetElement = e.target.parentNode
  console.log(targetElement.dataset.id)
  console.log(rawDashboards)
  const dashboards = rawDashboards
      ? rawDashboards.map((json) => DashboardVO.fromJSON(json))
      : [];

  dashboards.forEach((dashboardVO) => {
    if (targetElement.dataset.id === dashboardVO.id) {


      domDashboardTemplate.removeAttribute('id');
      domDashboardTemplate.remove();

      newDashboard.id = dashboardVO.id
      domDashboard.appendChild(newDashboard);
      while (newDashboard.children.length > 1) {
        newDashboard.removeChild(newDashboard.lastChild);
      }

      const columList = []

        for (var key in dashboardVO) {
          if(dashboardVO[key] && key !== 'id' && key !== 'dashboard_name') {
            columList.push(dashboardVO[key])
          }
        }

      columList.forEach(element => {
         const cloneCol = clone.cloneNode(true)
         if (!element.indexOf(dashboardVO.id)) {
           cloneCol.id = element
         } else {
           return
         }
         QUERY(cloneCol, 'columnNameTemp').innerText = columList[columList.indexOf(element) + 1]
         newDashboard.appendChild(cloneCol)
         cloneCol.classList.remove("hidden")
         QUERY(cloneCol, 'columnNameTemp').classList.remove("hidden")
         QUERY(cloneCol, 'columnNameInp').classList.add("hidden")
       })

      domDashboardName.innerText = dashboardVO.dashboard_name
    }
  })
}



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
            ? rawTasks.map((json) => TaskVO.fromJSON(json))
            : [];
        tasks.forEach((taskVO) => renderTask(taskVO));
      })
      .catch(function (error) {
      })
      .finally(function () {
      })
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
            switch (taskVO.id_status) {
              case 1:
                getDOM(Dom.Template.TASK_COLUMN_1).removeChild(domTask);
                break;
              case 2:
                getDOM(Dom.Template.TASK_COLUMN_2).removeChild(domTask);
                break;
              case 3:
                getDOM(Dom.Template.TASK_COLUMN_3).removeChild(domTask);
                break;
            }
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
          switch (taskVO.id_status) {
            case 1:
              getDOM(Dom.Template.TASK_COLUMN_1).replaceChild(domTaskUpdated, domTask);
              break;
            case 2:
              getDOM(Dom.Template.TASK_COLUMN_2).replaceChild(domTaskUpdated, domTask);
              break;
            case 3:
              getDOM(Dom.Template.TASK_COLUMN_3).replaceChild(domTaskUpdated, domTask);
              break;
          }
          updateTask(taskVO);
        }
      );
    },
  };


  getDOM(Dom.Template.DASHBOARD).onclick = (e) => {
    switch (e.target.dataset.id) {
      case 'btnAddTask':
        console.log('addTask')
        templatePopupCreateTask ();
        break;
      case 'btnAddColumn':
        console.log('click')
        createNewColumn (e.target);
        break;
    }


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
        console.log(taskTitle, taskBody, taskDate, taskTag, taskPriority)
        const taskId = `task_${Date.now()}`;
        const taskVO = new TaskVO(taskId, taskTitle, taskBody, taskDate, taskTag, taskPriority);
        console.log(taskVO)
        taskVO.id_status = 1;


        renderTask(taskVO);
        // tasks.push(taskVO);

        saveTask(taskVO);
      }
    );
  }


  function renderTask(taskVO) {

    domTemplateTask.classList.remove("hidden");
    const domTaskClone = domTemplateTask.cloneNode(true);
    domTaskClone.setAttribute('id', taskVO.id)
    domTaskClone.dataset.id = taskVO.id;

    QUERY(domTaskClone, DOM.Template.Task.TITLE).innerText = taskVO.title;
    QUERY(domTaskClone, DOM.Template.Task.BODY).innerText = taskVO.body;
    QUERY(domTaskClone, DOM.Template.Task.TAG).innerText = taskVO.tag;
    QUERY(domTaskClone, DOM.Template.Task.DATE).innerText = counterDaysLeft(taskVO.dt_end)
    templateColorIconClock (domTaskClone, counterDaysLeft(taskVO.dt_end))

    switch(parseInt(taskVO.tag)) {
      case 1:
        QUERY(domTaskClone, DOM.Template.Task.TAG).innerText = "Design";
        break;
      case 2:
        QUERY(domTaskClone, DOM.Template.Task.TAG).innerText = "Web";
        break;
      case 3:
        QUERY(domTaskClone, DOM.Template.Task.TAG).innerText = "Front";
        break;
      case 4:
        QUERY(domTaskClone, DOM.Template.Task.TAG).innerText = "Back";
        break;
    };
    switch(parseInt(taskVO.priority)) {
      case 1:
        QUERY(domTaskClone, DOM.Template.Task.PRIORITY).classList.add('text-red-500');
        break;
      case 2:
        QUERY(domTaskClone, DOM.Template.Task.PRIORITY).classList.add('text-orange-400');
        break;
      case 3:
        QUERY(domTaskClone, DOM.Template.Task.PRIORITY).classList.add('text-yellow-300');
        break;
      case 4:
        QUERY(domTaskClone, DOM.Template.Task.PRIORITY).classList.add('text-emerald-500');
        break;
    };


    switch (taskVO.id_status) {
      case 1:
        getDOM(Dom.Template.TASK_COLUMN_1).prepend(domTaskClone);
        break;
      case 2:
        getDOM(Dom.Template.TASK_COLUMN_2).prepend(domTaskClone);
        break;
      case 3:
        getDOM(Dom.Template.TASK_COLUMN_3).prepend(domTaskClone);
        break;
    }
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

  //____________________ Функции работы с базой данных_________________
function saveDashboard(dasboardVO) {
  let $dashboardVOdata = [];
  for (var key in dashboardVO) {
    $dashboardVOdata.push(dashboardVO[key])
  }
  axios.post('/createnewdashboard',
      JSON.parse(JSON.stringify($dashboardVOdata))
  )
      .then(function (response) {
        console.log(response);
      })
      .catch(function (error) {
        console.log(error);
      });
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
  let $status = taskVO.id_status

  let $taskVOdata;
  $taskVOdata = [$title, $body, $id, $date, $tag, $priority, $status]
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

//_________________Drag N Drop_______________________

domDashboard.addEventListener("drag", e)
domDashboard.addEventListener("dragstart", dragStart)

function dragStart(e) {
  const boxes = document.querySelectorAll("div[data-box]");
  boxes.forEach(box => {
    box.addEventListener('dragenter', dragEnter)
    box.addEventListener('dragover', dragOver);
    box.addEventListener('dragleave', dragLeave);
    box.addEventListener('drop', drop);
  });

  let elem = e.target;
  if (!elem.draggable) {
    return
  }
  e.dataTransfer.setData('text/plain', elem.id);
}
function e () {
}

function dragEnter(e) {
  e.preventDefault();
  e.target.classList.add('drag-over');
}

function dragOver(e) {
  e.preventDefault();
  e.target.classList.add('drag-over');
}

function dragLeave(e) {
}

function drop(e) {
  if (e.target.dataset.box) {

    const id = e.dataTransfer.getData('text/plain');
    const draggable = document.getElementById(id);

    e.target.appendChild(draggable);
    draggable.classList.remove('hidden');


    const taskVO = rawTasks.find((task) => task.id == id);

    if ( typeof taskVO.tag === 'string') {
      taskVO.tag = tagsArray[taskVO.tag]
    }
    taskVO.id_status = Number(e.target.id.toString().slice(-1))
    console.log(taskVO)

    updateTask(taskVO)

  }
}
////////////////// TASKS FILTERS /////////////////////////

domBtnShowFilter.onclick = () => {
  if (domBtnTagFilter.classList.contains("hidden")) {
    domBtnTagFilter.classList.remove("hidden")
    domBtnDateFilter.classList.remove("hidden")
  } else {
    domBtnTagFilter.classList.add("hidden")
    domBtnDateFilter.classList.add("hidden")
  }

  domBtnTagFilter.addEventListener('change', function (e) {
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
}
////////////////////////////////////////////////////////////