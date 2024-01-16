function display_c() {
    var refresh = 1000; // 设置时钟的刷新频率
    mytime = setTimeout('display_ct()', refresh)
}

function display_ct() {
    var x = new Date();
    var x1 = x.toUTCString(); // 获取当前的时间，并将其转换为UTC格式的字符串
    document.getElementById('ct').innerHTML = x1;
    tt = display_c();
}
