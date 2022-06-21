</div>
        <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
        </div>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/off-canvas.js"></script>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/hoverable-collapse.js"></script>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/misc.js"></script>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/jquery.min.js"></script>
    <?php if(auth()->isStudent()) : ?>
    <script>
        $(document).ready(()=>{


            function sendNotification (data) {
            if (data == undefined || !data) { return false }
            var title = (data.title === undefined) ? 'Notification' : data.title
            var clickCallback = data.clickCallback
            var message = (data.message === undefined) ? 'null' : data.message
            var icon = (data.icon === undefined) ? 'https://cdn2.iconfinder.com/data/icons/mixed-rounded-flat-icon/512/megaphone-64.png' : data.icon
            var sendNotification = function (){
                var notification = new Notification(title, {
                    icon: icon,
                    body: message
                })
                if (clickCallback !== undefined) {
                    notification.onclick = function () {
                        clickCallback()
                        notification.close()
                    }
                }
            }

            if (!window.Notification) {
                return false
            } else {
                if (Notification.permission === 'default') {
                    Notification.requestPermission(function (p) {
                        if (p !== 'denied') {
                            sendNotification()
                        }
                    })
                } else {
                    sendNotification()
                }
            }
        }

        function getInstantNots(){
            $.ajax({
                url:'/notification/index',
                type:'POST',
                data:{getNot:true},
                success:(res)=>{
                    let nots = JSON.parse(res);
                    if(nots.length != 0){
                        $("#redPill").show();
                        $("#notif-area").html("");
                        nots.forEach(el=>{
                            let notif = `<a class="dropdown-item preview-item" href="${el.link}" >
                                    <div class="preview-thumbnail">
                                      <div class="preview-icon bg-light">
                                        <img src="${el.icon}" width="70px" height="70px" style="border-radius:50%;" />
                                      </div>
                                    </div>
                                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                      <h6 class="preview-subject ellipsis font-weight-normal mb-1" title="${el.title}">${el.title}</h6>
                                      <p class="text-gray ellipsis mb-0" title="${el.content}">${el.content}</p>
                                    </div>
                                  </a>
                                  <div class="dropdown-divider"></div>`;
                            $("#notif-area").append(notif);
                            sendNotification({
                                title: el.title,
                                message: el.content,
                                icon:el.icon,
                                clickCallback: function () {
                                    window.open(el.link);
                                }
                            });
                        });
                        
                    }
                }
            });
        }

        // notification function            
        setInterval(()=>{
            getInstantNots();
        },3000);


        });
    </script>
    <?php endif ?>