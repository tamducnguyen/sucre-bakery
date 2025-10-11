<?php
function set_toast_message($message)
{
    $_SESSION["toast_message"] = $message;
}

function get_toast_message()
{
    return $_SESSION["toast_message"] ?? null;
}

function unset_toast_message()
{
    unset($_SESSION["toast_message"]);
}

function toast_session()
{
    $toast_message = get_toast_message();
    if ($toast_message) {
        toast($toast_message);
        unset_toast_message();
    }
}

function toast($message)
{ ?>
    <div class="toast-panel">
        <div class="toast-process"></div>
        <p class="toast-message"><?= $message ?></p>
    </div>

    <style class="toast-style">
        .toast-panel {
            animation: move-toast-panel-in 0.4s ease forwards;
            background-color: white;
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;
            bottom: 20px;
            box-shadow: 0 4px 8px var(--shadow-color);
            left: -25%;
            position: fixed;
            width: 25%;
            z-index: 3;
        }

        .toast-process {
            animation: move-toast-process 4s linear forwards;
            background-color: var(--brown-color);
            height: 6px;
            width: 0%;
        }

        .toast-message {
            color: black;
            font-family: "Roboto";
            font-size: 20px;
            line-height: 28px;
            padding: 16px;
        }

        @keyframes move-toast-panel-in {
            0% {
                left: -25%;
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                left: 20px;
                opacity: 1;
            }
        }

        @keyframes move-toast-panel-out {
            0% {
                left: 20px;
                opacity: 1;
            }

            50% {
                opacity: 1;
            }

            100% {
                left: -25%;
                opacity: 0;
            }
        }

        @keyframes move-toast-process {
            to {
                width: 100%;
            }
        }
    </style>

    <script class="toast-script">
        function hide_toast() {
            const parent = document.body;
            const toastPanel = document.getElementsByClassName("toast-panel")[0];
            const toastStyle = document.getElementsByClassName("toast-style")[0];
            const toastScript = document.getElementsByClassName("toast-script")[0];

            parent.appendChild(toastPanel);
            parent.appendChild(toastStyle);
            parent.appendChild(toastScript);

            setTimeout(() => {
                toastPanel.style.animation = "move-toast-panel-out 0.4s ease forwards";

                setTimeout(() => {
                    toastPanel.remove();
                    toastStyle.remove();
                    toastScript.remove();
                }, 400);
            }, 4000);
        }

        hide_toast();
    </script>
<?php } ?>