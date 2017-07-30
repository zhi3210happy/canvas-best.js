 ! function() {
  //封装方法，压缩之后减少文件大小
  function get_attribute(node, attr, default_value) {
    return node.getAttribute(attr) || default_value;
  }  
   //封装方法，压缩之后减少文件大小
   function get_by_tagname(name) {
    return document.getElementsByTagName(name);
  }  
    //  获取配置参数 
   function get_config_option() {
    var scripts = get_by_tagname("script"),
      script_len = scripts.length,
      script = scripts[script_len - 1]; //当前加载的script
    return {
      l: script_len, //长度，用于生成id用
      z: get_attribute(script, "zIndex", 1), //z-index
      o: get_attribute(script, "opacity",1), //opacity
      c: get_attribute(script, "color", 360), //color
      n: get_attribute(script, "count", 3000), //count
      s: get_attribute(script, "speed", 4),
      r: get_attribute(script, "range", 80),
      l: get_attribute(script, "lineAlpha", 0.05)
      // f: get_attribute(script, "fillstyle", 0.05)
    };
  }       
var the_canvas= document.createElement("canvas"),//画布
    config = get_config_option(), //配置   
    w = the_canvas.width =document.body.scrollWidth,
    h = the_canvas.height =document.body.scrollHeight,
    ctx = the_canvas.getContext('2d'),
               //数量基数 标准为3000,越大 数量越少，建议不要小于1000，否则会卡死。
    count = (w*h/config.n)|0,   //数量
    speed = config.s,              //速度
    range = config.r,             //长度
    lineAlpha =config.l,       //颜色深度
    
    particles = [],
                //颜色基数 360为标准。
    color = config.c/count;    //颜色
 get_by_tagname("body")[0].appendChild(the_canvas);
 the_canvas.id =config.l;
 the_canvas.style.cssText = "position:absolute;top:0;left:0;z-index:"+config.z+";opacity:"+config.o;
for(var i = 0; i < count; ++i)
  particles.push(new Particle((color*i)|0));

function Particle(hue){
  this.x = Math.random()*w;
  this.y = Math.random()*h;
  this.vx = (Math.random()-.5)*speed;
  this.vy = (Math.random()-.5)*speed;
  
  this.hue = hue;
}
Particle.prototype.update = function(){
  this.x += this.vx;
  this.y += this.vy;
  
  if(this.x < 0 || this.x > w) this.vx *= -1;
  if(this.y < 0 || this.y > h) this.vy *= -1;
}

function checkDist(a, b, dist){
  var x = a.x - b.x,
      y = a.y - b.y;
  
  return x*x + y*y <= dist*dist;
}
// var my_gradient=ctx.createLinearGradient(0,0,0,h);
// my_gradient.addColorStop(0,"yellow");
// my_gradient.addColorStop(1,"white");
// ctx.fillStyle=my_gradient;
  ctx.fillStyle = 'rgba(255, 255, 255, 0.05)';
function anim(){
  window.requestAnimationFrame(anim);
  

  ctx.fillRect(0, 0, w, h);
  
  for(var i = 0; i < particles.length; ++i){
    var p1 = particles[i];
    p1.update();
    
    for(var j = i+1; j < particles.length; ++j){
      var p2 = particles[j];
      if(checkDist(p1, p2, range)){
        ctx.strokeStyle = 'hsla(hue, 80%, 50%, alp)'
          .replace('hue', ((p1.hue  + p2.hue + 3)/2) % 360)
          .replace('alp', lineAlpha);
        ctx.beginPath();
        ctx.moveTo(p1.x, p1.y);
        ctx.lineTo(p2.x, p2.y);
        ctx.stroke();
      }
    }
  }
}

anim();
}();
