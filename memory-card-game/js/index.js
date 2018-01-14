var NR_OF_CARDS = 20;
var CARD_ARRAY = [];
var NR_OF_FLIPS = 0;
var FOUND_CARDS = [];
var VALUE_LIST = [0, 0, 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 9, 9];
var PICKED_CARD = -1;
var TRYS = 0;

function Card(id, val) {
  this.id = id;
  this.value = val;
  this.flipped = false;
}

function createCardArray() {
  for (var i = 0; i < NR_OF_CARDS; i++) {
    CARD_ARRAY.push(new Card(i, VALUE_LIST[i]));
  }
}

function initListener() {
  var cards = document.querySelectorAll(".card.effect_on_click");
  for (var i = 0, len = cards.length; i < len; i++) {
    var card = cards[i];
    clickListener(card, i);
  }
}

function clickListener(card, i) {
  card.addEventListener("click", function() {
    var c = this.classList;
    console.log("nr flips:" + NR_OF_FLIPS);

    if (NR_OF_FLIPS != 2 && !notInFoundCards(i)) {
      c.contains("flipped") === true ?
        c.remove("flipped") : c.add("flipped");
      NR_OF_FLIPS++;
      console.log("nr flips2:" + NR_OF_FLIPS);
      console.log("last:" + PICKED_CARD);
      check_if_match(i, PICKED_CARD);
      PICKED_CARD = i;
      console.log(PICKED_CARD);
      addTrys();
    } else {
      reset();
    }

  });
}

function reset() {
  NR_OF_FLIPS = 0;
  PICKED_CARD = -1;
  var cards = document.querySelectorAll(".card.effect_on_click");
  for (var i = 0, len = cards.length; i < len; i++) {
    var card = cards[i];
    var c = card.classList;
    if (c.contains("flipped") == true && !notInFoundCards(i)) {
      c.remove("flipped");
    }
  }
}

function hardreset() {
  this.NR_OF_CARDS = 20;
  this.CARD_ARRAY = [];
  this.NR_OF_FLIPS = 0;
  this.FOUND_CARDS = [];
  this.VALUE_LIST = [0, 0, 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 9, 9];
  this.PICKED_CARD = -1;
  this.TRYS = 0;

  var cards = document.querySelectorAll(".card.effect_on_click");
  for (var i = 0, len = cards.length; i < len; i++) {
    var card = cards[i];
    var c = card.classList;
    if (c.contains("flipped") == true) {
      c.remove("flipped");
    }
  }
  document.getElementById("trys").innerHTML = "Tries: " + this.TRYS;
  shuffleValueList();
  createCardArray();
  setImages();
}

function notInFoundCards(card_nr) {
  for (var i = 0; i < FOUND_CARDS.length; i++) {
    if (card_nr == FOUND_CARDS[i]) {
      return true;
    }
  }
  return false;
}

function returnCardValue(i) {
  console.log("as:" + i);
  if (i != -1) {
    return CARD_ARRAY[i].value;
  } else {
    return -1;
  }
}

function check_if_match(i, j) {
  if (returnCardValue(i) == returnCardValue(j) && !notInFoundCards(i) && !notInFoundCards(j) && i != j) {
    FOUND_CARDS.push(i);
    FOUND_CARDS.push(j);
  }
  console.log("fc:" + FOUND_CARDS);
}

var img = [
  'http://img5.uploadhouse.com/fileuploads/17699/176992640c06707c66a5c0b08a2549c69745dc2c.png',
  'http://img6.uploadhouse.com/fileuploads/17699/17699263b01721074bf094aa3bc695aa19c8d573.png',
  'http://img6.uploadhouse.com/fileuploads/17699/17699262833250fa3063b708c41042005fda437d.png',
  'http://img9.uploadhouse.com/fileuploads/17699/176992615db99bb0fd652a2e6041388b2839a634.png',
  'http://img4.uploadhouse.com/fileuploads/17699/176992601ca0f28ba4a8f7b41f99ee026d7aaed8.png',
  'http://img3.uploadhouse.com/fileuploads/17699/17699259cb2d70c6882adc285ab8d519658b5dd7.png',
  'http://img2.uploadhouse.com/fileuploads/17699/1769925824ea93cbb77ba9e95c1a4cec7f89b80c.png',
  'http://img7.uploadhouse.com/fileuploads/17699/1769925708af4fb3c954b1d856da1f4d4dcd548a.png',
  'http://img9.uploadhouse.com/fileuploads/17699/176992568b759acd78f7cbe98b6e4a7baa90e717.png',
  'http://img9.uploadhouse.com/fileuploads/17699/176992554c2ca340cc2ea8c0606ecd320824756e.png'
];

function setImages() {
  var cards = document.querySelectorAll(".card_back");
  for (var i = 0, len = cards.length; i < len; i++) {
    cards[i].style.background = "url(" + img[CARD_ARRAY[i].value] + ")";
  }
}

function shuffleValueList() {
  var temp;
  var temp2;
  for (var i = VALUE_LIST.length; i > 0; i--) {
    temp2 = VALUE_LIST[i - 1];
    temp = Math.floor(Math.random() * i);
    VALUE_LIST[i - 1] = VALUE_LIST[temp];
    VALUE_LIST[temp] = temp2;
  }
}

function addTrys() {
  TRYS += 1;
  document.getElementById("trys").innerHTML = "Tries: " + TRYS;

}

shuffleValueList();
createCardArray();
setImages();
initListener();

setInterval(function() {
  if (FOUND_CARDS.length == 20) {
    document.getElementById("trys").innerHTML = "YOU WON! Tries: " + TRYS;

  }

}, 1000);