<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Vite App</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @tailwind base;
    @tailwind components;
    @tailwind utilities;

    .spinner {
      display: inline-block;
      width: 50px;
      height: 50px;
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: #fff;
      animation: spin 1s ease-in-out infinite;
      -webkit-animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to {
        -webkit-transform: rotate(360deg);
      }
    }
    @-webkit-keyframes spin {
      to {
        -webkit-transform: rotate(360deg);
      }
    }
  </style>
</head>
<body class="grid h-screen w-screen place-items-center bg-teal-100/50 p-6 font-sans">
<div
    id="popupContainer"
    class="fixed left-0 top-0 z-10 grid hidden h-screen w-screen place-items-center bg-black/70"
>
  <div class="spinner"></div>
</div>
<div class="container flex h-full w-full flex-row rounded-3xl bg-gray-200/90 p-4">
  <aside class="flex min-w-[300px] flex-col">
    <div>
      <div class="flex flex-row items-center gap-x-2 py-4">
        <i class="i-ph:cube-focus-bold text-3xl text-teal-700"></i>
        <span class="text-xl font-bold">Taski</span>
      </div>
      <div class="flex flex-row">
        <div>
          <img
              src="https://cdn3.iconfinder.com/data/icons/user-2/100/10-512.png"
              class="m-auto w-12 rounded-full shadow"
          />
        </div>
        <div class="mx-2 flex flex-col justify-center">
          <div class="text-xl font-bold">Name Surname</div>
          <div class="text-xs font-thin">Premium account</div>
        </div>
      </div>

      <div class="my-4 mr-4 flex flex-col text-neutral-500">
        <div class="mr-4 flex w-full">
          <div class="flex w-full flex-row items-center justify-between">
            <div class="my-1 flex flex-row items-center hover:text-teal-900 hover:font-bold">
              <i class="i-carbon:user-activity w h-5 w-5"></i>
              <span class="mx-2">Activity</span>
            </div>
            <div class="flex rounded-2xl bg-teal-600 px-2.5 py-0.5">
              <span class="text-xs text-white">0</span>
            </div>
          </div>
        </div>
        <div class="my-1 flex flex-row items-center rounded-md hover:text-teal-900 hover:font-bold">
          <i class="i-et:profile-male h-5 w-5"></i>
          <span class="mx-2">My Profile</span>
        </div>
      </div>
    </div>
    <div class="mr-4 flex flex-col border-b border-t border-gray-400">
      <div class="my-4 flex flex-col">
        <div class="flex flex-row ml-1.5 items-center justify-between">
          <div class="my-2 text-xl font-bold">Pages</div>
          <div class="mr-1.5 flex text-neutral-400">
            <i class="i-fa-solid:chevron-up hover:text-neutral-600"></i>
          </div>
        </div>
        <div class="flex flex-col text-neutral-500">
          <div class="flex flex-row rounded-md hover:bg-teal-600/20 hover:text-teal-900 hover:font-bold">
            <div class="flex flex-row items-center m-1.5">
              <i class="i-radix-icons:dashboard"></i>
              <span class="mx-2">Dashboard</span></div>
          </div>
          <div class="flex flex-row rounded-md hover:bg-teal-600/20 hover:text-teal-900 hover:font-bold">
            <div class="flex flex-row items-center m-1.5">
              <i class="i-clarity:tasks-solid"></i>
              <span class="mx-2">Tasks</span></div>
          </div>
          <div class="flex flex-row rounded-md hover:bg-teal-600/20 hover:text-teal-900 hover:font-bold">
            <div class="flex flex-row items-center m-1.5">
              <i class="i-fluent:people-team-16-regular"></i>
              <span class="mx-2">Teams</span></div>
          </div>
          <div class="flex flex-row rounded-md hover:bg-teal-600/20 hover:text-teal-900 hover:font-bold">
            <div class="flex flex-row items-center m-1.5">
              <i class="i-jam:messages"></i>
              <span class="mx-2">Messages</span></div>
          </div>
          <div class="flex flex-row rounded-md hover:bg-teal-600/20 hover:text-teal-900 hover:font-bold">
            <div class="flex flex-row items-center m-1.5">
              <i class="i-solar:calendar-linear"></i>
              <span class="mx-2">Calendar</span></div>
          </div>
        </div>
      </div>
    </div>
    <div class="flex h-full flex-col justify-between">
      <div class="my-4 mr-4 flex flex-col">
        <div class="flex flex-row ml-1.5 items-center justify-between">
          <div class="my-2 text-xl font-bold">Labels</div>
          <div class="mr-1.5 flex text-neutral-400">
            <i class="i-fa-solid:chevron-up hover:text-neutral-600"></i>
          </div>
        </div>
        <div class="flex flex-col text-neutral-500">
          <div class="flex w-full flex-row items-center justify-between">
            <div class="my-1 flex flex-row items-center">
              <i
                  class="i-ic:sharp-play-arrow h-7 w-7 bg-red-500 hover:text-neutral-600"
              ></i>
              <span class="mx-2">High Priority</span>
            </div>
            <div class="flex rounded-2xl bg-neutral-300 px-2.5 py-0.5 hover:bg-teal-600 hover:text-white">
              <span class="text-xs">0</span>
            </div>
          </div>
          <div class="flex w-full flex-row items-center justify-between">
            <div class="my-1 flex flex-row items-center">
              <i
                  class="i-ic:sharp-play-arrow h-7 w-7 bg-orange-400 hover:text-neutral-600"
              ></i>
              <span class="mx-2">Medium Priority</span>
            </div>
            <div class="flex rounded-2xl bg-neutral-300 px-2.5 py-0.5 hover:bg-teal-600 hover:text-white">
              <span class="text-xs ">0</span>
            </div>
          </div>
          <div class="flex w-full flex-row items-center justify-between">
            <div class="my-1 flex flex-row items-center">
              <i
                  class="i-ic:sharp-play-arrow h-7 w-7 bg-yellow-300 hover:text-neutral-600"
              ></i>
              <span class="mx-2">Low Priority</span>
            </div>
            <div class="flex rounded-2xl bg-neutral-300 px-2.5 py-0.5 hover:bg-teal-600 hover:text-white">
              <span class="text-xs">0</span>
            </div>
          </div>
          <div class="flex w-full flex-row items-center justify-between">
            <div class="my-1 flex flex-row items-center">
              <i
                  class="i-ic:sharp-play-arrow h-7 w-7 bg-emerald-500 hover:text-neutral-600"
              ></i>
              <span class="mx-2">On Standby</span>
            </div>
            <div class="flex rounded-2xl bg-neutral-300 px-2.5 py-0.5 hover:bg-teal-600 hover:text-white">
              <span class="text-xs">0</span>
            </div>
          </div>
        </div>
      </div>
      <div class="my-2 flex flex-col text-neutral-400">
        <div class="my-1 flex flex-row items-center hover:text-neutral-600">
          <i class="i-material-symbols:info-outline "></i>
          <span class="mx-2">Help center</span>
        </div>
        <div class="my-1 flex flex-row items-center hover:text-neutral-600">
          <i class="i-ic:baseline-log-out"></i>
          <span class="mx-2">Log out</span>
        </div>
      </div>
    </div>
  </aside>
  <main class="flex h-full w-full flex-col">
    <div class="flex h-full w-full flex-col gap-y-4 rounded-t-2xl bg-gray-50 px-4 pb-4 pt-2">
      <div class="flex flex-row items-center justify-between">
        <div class="flex flex-col">
          <span class="text-lg font-bold">Team tasks</span>
        </div>
        <div class="flex flex-col">
          <div class="flex flex-row items-center gap-x-4 ">
            <div class="flex flex-row px-18 py-1 bg-gray-200/90 rounded-md pl-1 items-center text-neutral-400 ">
              <i class="i-system-uicons:search hover:text-neutral-600"></i>
              <div>Search</div>
            </div>
            <button id="btnCreateTask" class="rounded-md bg-teal-600 px-4 py-1.5">
              <span class="text-white">+ Create Task</span>
            </button>
          </div>
        </div>
      </div>
      <div class="flex flex-row items-center justify-between">
        <div class="flex flex-col">
          <div class="flex flex-row items-center gap-x-1 text-neutral-400">
            <i class="i-mdi-filter hover:text-neutral-600"></i>
            <span class="text-xs"> Filters </span>
            <i class="i-mdi-chevron-down hover:text-neutral-600"></i>
          </div>
        </div>
        <div class="flex flex-col">
          <div class="flex flex-row items-center gap-x-8">
            <div class="flex flex-row gap-x-1 text-neutral-400">
              <span class="text-xs">Sort by</span>
              <i class="i-mdi-chevron-down hover:text-neutral-600"></i>
            </div>
            <div class="flex flex-row">
              <div class="flex flex-col">
                <div class="flex flex-row text-neutral-400">
                  <span class="text-xs mr-1">Group by:</span>
                  <div class="flex flex-row">
                    <span class="text-xs">Status</span>
                    <i class="i-mdi-chevron-down hover:text-neutral-600"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr />
      <div class="flex flex-row justify-between gap-x-4">
        <div
            class="border-1 flex h-full w-1/3 flex-col rounded-xl border-gray-300/50 bg-gray-200 p-2"
        >
          <div class="flex flex-row justify-between px-1 py-1">
            <div class="flex flex-row gap-x-1 font-bold">
              <span>To Do </span>
              <span class="text-gray-400">0</span>
            </div>
            <div class="flex flex-col text-neutral-500">+ ...</div>
          </div>
          <div class="flex flex-row pt-2">
            <div
                data-test-id="tasks-column"
                class="flex w-full flex-col justify-start justify-between gap-y-4"
            >
              <div
                  id="templateTask"
                  class="border-1 flex flex-row rounded-lg border-neutral-100 bg-neutral-50 px-3 py-3 shadow"
              >
                <div class="flex w-full flex-col gap-y-3">
                      <span data-id="templateTaskTitle" class="pointer-events-none font-bold"
                      >$name</span
                      >
                  <div class="pointer-events-none flex flex-row justify-between">
                    <div class="flex flex-row gap-x-2">
                      <div
                          class="rounded-lg bg-neutral-200/60 px-2 py-1 text-xs text-neutral-600"
                      >
                        Update
                      </div>
                      <div
                          class="rounded-lg bg-neutral-200/60 px-2 py-1 text-xs text-neutral-600"
                      >
                        Web
                      </div>
                    </div>
                    <div class="flex flex-row items-center gap-x-1">
                      <div class="i-mdi-clock-time-eight-outline text-sm text-green-600"></div>
                      <div class="text-xs text-neutral-400">12 days left</div>
                    </div>
                  </div>
                  <div class="flex justify-between">
                    <div class="flex flex-row -space-x-2">
                          <span
                              class="h-6 w-6 rounded-full border-2 border-green-500 bg-green-300"
                          ></span>
                      <span
                          class="h-6 w-6 rounded-full border-2 border-yellow-500 bg-yellow-300"
                      ></span>
                      <span
                          class="grid h-6 w-6 place-items-center rounded-full border-2 border-blue-500 bg-blue-300"
                      ><span class="text-xs font-bold text-blue-600">+2</span></span
                      >
                    </div>
                    <div class="flex flex-row gap-2">
                      <button
                          data-btn="btnEdit"
                          class="text-neutral-400 hover:text-neutral-800"
                      >
                        <i
                            class="i-material-symbols-edit pointer-events-none block text-2xl"
                        ></i>
                      </button>
                      <button
                          data-btn="btnDelete"
                          class="text-neutral-400 hover:text-neutral-800"
                      >
                        <i
                            class="i-material-symbols-delete pointer-events-none block text-2xl"
                        ></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <button class="w-full rounded-lg bg-neutral-50 py-2 text-neutral-500 shadow">
                + Add task
              </button>
            </div>
          </div>
        </div>
        <div
            class="border-1 flex h-full w-1/3 flex-col rounded-xl border-gray-300/50 bg-gray-200 p-2"
        >
          <div class="flex flex-row justify-between px-1 py-1">
            <div class="flex flex-row gap-x-1 font-bold">
              <span>In Progress </span>
              <span class="text-gray-400">0</span>
            </div>
            <div class="flex flex-col text-neutral-500">+ ...</div>
          </div>
          <div class="flex flex-row pt-2">
            <div
                data-test-id="tasks-column"
                class="flex w-full flex-col justify-start justify-between gap-y-4"
            >
              <button class="w-full rounded-lg bg-neutral-50 py-2 text-neutral-500 shadow">
                + Add task
              </button>
            </div>
          </div>
        </div>
        <div
            class="border-1 flex h-full w-1/3 flex-col rounded-xl border-gray-300/50 bg-gray-200 p-2"
        >
          <div class="flex flex-row justify-between px-1 py-1">
            <div class="flex flex-row gap-x-1 font-bold">
              <span>In Review </span>
              <span class="text-gray-400">0</span>
            </div>
            <div class="flex flex-col text-neutral-500">+ ...</div>
          </div>
          <div class="flex flex-row pt-2">
            <div
                data-test-id="tasks-column"
                class="flex w-full flex-col justify-start justify-between gap-y-4"
            >
              <button class="w-full rounded-lg bg-neutral-50 py-2 text-neutral-500 shadow">
                + Add task
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
        class="mt-1 flex w-full flex-row gap-y-4 rounded-b-2xl bg-gray-50 px-4 pb-4 pt-2"
    >
      <div class="flex flex-row ml-3 items-center text-neutral-400 hover:text-teal-600">
        <div class="font-semibold"><?php echo $count . " tasks" ?></div>
        <i class="i-ion:chevron-down-outline  ml-3"></i>
      </div>
    </div>
  </main>
</div>
<script type="module" src="./../../assets/js/main.js"></script>
</body>
</html>
