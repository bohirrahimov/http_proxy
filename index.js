const tagnames = ['p','h1','h2','h3', 'h4', 'h5', 'h6'];
let result = '';
let list = [];
let string = "";
let newword = "";
let elements = [];
for(let i=0; i<tagnames.length; i++){
    elements = document.querySelectorAll(tagnames[i]);
    elements.forEach(el =>{
        result = el.innerHTML;
        string = el.innerHTML;
        result = result.replaceAll(/[^\w ]/g, " ");
        list = result.split(" ");
    list.map(word => {
        if(word.length === 6){
            newword = word + "™";
            el.innerHTML = el.innerHTML.replaceAll(word, newword);
        }

    });
        
    });
    }
