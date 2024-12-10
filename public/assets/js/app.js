var baseUrl = window.location.origin;

var req = {
    page:1
};

const menuByRole = {
    "admin": ["dashboard", "user", "coach"],
    "user" : ["dashboard", "user"],
    "coach" : ["dashboard", "user", "coach"]
}

const sidebarItems = [
    {
      url: "dashboard",
      icon: "ni ni-archive-2",
      label: "Dashboard"
    },
    {
      url: "user",
      icon: "ni ni-single-02",
      label: "User Management"
    },
    {
      url: "coach",
      icon: "ni ni-support-16",
      label: "Coach Management"
    },
];

// Get CSRF token from meta tag
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
           document.querySelector('meta[name="csrf_token"]')?.getAttribute('content') || 
           '';
}

// Set up AJAX defaults
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': getCsrfToken(),
        'Authorization': 'Bearer ' + session("token")
    }
})

function ajaxData(url, type, data , successFunc = "", errorFunc = "") {
    return $.ajax({
        url: url,
        type: type,
        dataType:"JSON",
        data: data,
        success: function (resp) {
            if(!empty(successFunc)) {
                successFunc(resp);
            }
        },
        error: function (data) {
            let code = data.responseJSON?.code;
            if (code >= 500) toast("Something went wrong, please try again", 'danger');
            else toast(data.responseJSON?.message ?? data.responseJSON?.error, 'warning')
            if(typeof errorFunc === "function") {
                errorFunc(data);
            }
        }
    });
}

function ajaxDataFile(url, type, data , successFunc = "", errorFunc = "") {
    return $.ajax({
        url: url,
        type: type,
        dataType:"JSON",
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        success: function (resp) {
            if(!empty(successFunc)) {
                successFunc(resp);
            }
        },
        error: function (data) {
            let code = data.responseJSON.code;
            if (code >= 500) toast("Something went wrong, please try again", 'danger');
            else toast(data.responseJSON.message ?? data.responseJSON.error, 'warning')
            if(typeof errorFunc === "function") {
                errorFunc(data);
            }
        }
    });
}

function setSession(name, value) {
    localStorage.setItem(name, value);
}
function session(name) {
    return localStorage.getItem(name) ?? "";
}

function checkLogin() {
    if(empty(session("isLogin"))) {
        toast("Session expired, please login again", 'danger');
        setTimeout(function(){
            deleteSession();
        }, 300);
    } else {
      
        ajaxData(baseUrl + '/api/v1/user', 'POST', {}, function (resp) {
            $(".display-user-name").html(resp.data.name);
            let role = (resp.data.role == "user" ? "user" : resp.data.role); ;
            $(".display-user-role").html(role);
            setSession("role", resp.data.role);
            // if (role == "user") {
            //     let isVerificator = resp.data.dataRole.find((element) => element.nama_role == "Knowledge Verificator");
            //     let isContributor = resp.data.dataRole.find((element) => element.nama_role == "Knowledge Contributor");
            //     setSession("id", resp.data.id);

            //     if (typeof isVerificator === 'object') {
            //         if (Object.keys(isVerificator).length === 0) {
            //             setSession("data-role-verificator", "tidak");
            //         } else {
            //             setSession("data-role-verificator", "ada");
            //         }
            //     } else {
            //      setSession("data-role-verificator", "tidak");
            //     }
                
            //     if (typeof isContributor === 'object') {
            //         if (Object.keys(isContributor).length === 0) {
            //             setSession("data-role-contributor", "tidak");
            //         } else {
            //             setSession("data-role-contributor", "ada");
            //         }
            //     } else {
            //     setSession("data-role-contributor", "tidak");
 
            //     }

            // } else {
            //     setSession("data-role-verificator", "tidak");
            //     setSession("data-role-contributor", "tidak");
            // }
            setSession("is_upload_google_form", resp.data.is_upload_google_form);
            checkUserAccess()
            setMenuByRole();
            // checkSpecialAction(resp.data)
        }, function(data) {
            
            toast(data.responseJSON.message ?? data.responseJSON.error, 'warning');
            setTimeout(deleteSession, 300);
        });
    }
}

function checkUserAccess(){
    const role = session("role");
    let accessMenu = [];
    
    accessMenu = menuByRole[`${role}`].filter(item => {
        let pathname = window.location.pathname.replace(/\.html$/, '').replace(/[/]/g, '');
        pathname = pathname.replace(/^kmspublic/, '');
        let menuUrl = item.replace(/_/g, '-');
        if (item == "*") return true;
        return pathname == menuUrl
    });    
    
    if (empty(accessMenu)) {
        toast("Access Denied", 'danger');
        setTimeout(function(){
            // redirect to login
            window.location = baseUrl + '/auth-login.html';
        }, 300);
    }
    
}

function setMenuByRole(){
    const role = session("role");

    const menu = menuByRole[role];
    const sidebarMenu = sidebarItems.filter(item => {
        let menuUrl = item.url.replace(/_/g, '-');
        return menu.includes(menuUrl)
    });
   console.log(menu);
   
    // add list menu
    sidebarMenu.forEach(function(item){
        let menuItem = `
            <li class="nav-item">
                <a class="nav-link" href="${item.url}.html">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ${item.icon} text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">${item.label}</span>
                </a>
            </li>
                       
        `
        $(".collapse .navbar-nav").append(menuItem);
    });

    // active menu
    $(".collapse .navbar-nav .nav-item").each(function(index, menu){
        let pathname = window.location.pathname.replace(/[/-]/g, '');
        pathname = pathname.replace(/^kmspublic/, '');
        let urlSidebar = $(this).find("a").attr("href").replace(/[/-]/g, '');
        const hrefRegex = new RegExp(`^${urlSidebar.replace(/\//g, '')}$`);
       
        if(hrefRegex.test(pathname)){
            $(this).addClass("active");
        }
    });
    
}

function deleteSession() {
    localStorage.removeItem("role");
    localStorage.removeItem("isLogin");
    localStorage.removeItem("token");
    window.location = baseUrl + '/auth-login.html';
}

function GetData(req , table, formatFunc = "" ,successfunc = "") {
    req = (typeof req !== 'undefined') ?  req : "";
    successfunc = (typeof successfunc !== 'undefined') ?  successfunc : "";
    url = $(`.datatable-${table}`).data("action");

    
    // add loading on table use font awesome reolad 
    $(`.datatable-${table} tbody`).html(`<tr><td colspan='10' class='text-center'><div class="spinner-border text-primary" role="status"></div></td></tr>`);
    $.ajax({
        type: "GET",
        url: baseUrl + url,
        data: req,
        dataType: "JSON",
        tryCount: 0,
        retryLimit: 3,
        success: function(resp){
            resp.lsdt = "";
            if(!empty(resp.meta)) {
                if(typeof formatFunc !== "function") {
                    return;
                }
                resp.lsdt = formatFunc(resp.data);
                $(".datatable-"+table+" tbody").html(resp.lsdt);
                pagination(resp.meta, table);
                if(successfunc != "") {
                    getfunc = successfunc;
                    successfunc(resp);
                }
            } else {
                if(typeof formatFunc !== "function") {
                    return;
                }
                resp.lsdt = formatFunc(resp.data);
                $(".datatable-"+table+" tbody").html(resp.lsdt);
                $(".pagination-setting-"+table).addClass("hidden");
                if(successfunc != "") {
                    getfunc = successfunc;
                    successfunc(resp);
                }
            }
        },
        error: function(xhr, textstatus, errorthrown) {
            $(".datatable-"+table+" tbody").html("<tr><td colspan='10' class='text-center'><span class='label label-warning'>Periksa koneksi internet anda kembali</span></td></tr>");
            $(".pagination-setting-"+table).addClass("hidden");
        }
    });
}

function pagination(page, table) {
    var paginglayout = $(".pagination-setting-"+table);
    let stringInfo = `${page.from} - ${page.to} of ${page.total} Records`;
    if (empty(page.from)) {
        stringInfo = "";
    }
    var infopage = stringInfo + " | total " + page.last_page + " Pages";
    page.IsNext = page.current_page < page.last_page;
    page.IsPrev = page.current_page > 1;

    paginglayout.attr("page", page.current_page);
    paginglayout.attr("lastpage", page.last_page);
    paginglayout.removeClass("hidden");
    paginglayout.find("input[type='text']").val(Number(page.current_page));
    paginglayout.find(".pagination-info").html(infopage);
    if(page.IsNext == true) {
        paginglayout.find(".btn-next, .next-head").removeClass("disabled");
        paginglayout.find(".btn-last").removeClass("disabled");
        paginglayout.find(".btn-last").attr("lastpage", page.JmlHalTotal);
        datanext = (Number(page.current_page) + 1);
    } else {
        paginglayout.find(".btn-next, .next-head").addClass("disabled");
        paginglayout.find(".btn-last").addClass("disabled");
        dataprev = 0;
    }
    if(page.IsPrev == true) {
        paginglayout.find(".btn-prev, .prev-head").removeClass("disabled");
        paginglayout.find(".btn-first").removeClass("disabled");
        dataprev = (Number(page.current_page) - 1);
    } else {
        paginglayout.find(".btn-prev, .prev-head").addClass("disabled");
        paginglayout.find(".btn-first").addClass("disabled");
        dataprev = 0;
    }
}

function empty(value) {
    // empty array
    return (value === undefined || value === null || value.length === 0 || value === "") ? true : false;
}

function toast(message, type = "success") {
    switch(type) {
        case 'primary': type = '#435ebe'; break;
        case 'secondary': type = '#6c757d'; break;
        case 'success': type = '#198754'; break;
        case 'danger': type = '#dc3545'; break;
        case 'warning': type = '#ffc107'; break;
        case 'info': type = '#0dcaf0'; break;
        default: type = '#6c757d';
    }

    if (empty(message)) {
        return;
    }

    Toastify({
        text: message,
        duration: 3000,
        close:true,
        backgroundColor: type,
    }).showToast();
}