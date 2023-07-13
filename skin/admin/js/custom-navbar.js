
/**
 * Navbar Custom
 *
 */
const dropdownBtn = document.querySelectorAll(".dropdown-btn");
const dropdown = document.querySelectorAll(".dropdown");
const hamburgerBtn = document.getElementById("hamburger");
const navMenu = document.querySelector(".menu");
const links = document.querySelectorAll(".dropdown a");

function setAriaExpandedFalse() {
  dropdownBtn.forEach((btn) => btn.setAttribute("aria-expanded", "false"));
}

function closeDropdownMenu() {
  dropdown.forEach((drop) => {
    drop.classList.remove("active");
    drop.addEventListener("click", (e) => e.stopPropagation());
  });
}

function toggleHamburger() {
  if(navMenu) navMenu.classList.toggle("show");
}

dropdownBtn.forEach((btn) => {
  btn.addEventListener("click", function (e) {
    const dropdownIndex = e.currentTarget.dataset.dropdown;
    const dropdownElement = document.getElementById(dropdownIndex);

    dropdownElement.classList.toggle("active");
    dropdown.forEach((drop) => {
      if (drop.id !== btn.dataset["dropdown"]) {
        drop.classList.remove("active");
      }
    });
    e.stopPropagation();
    btn.setAttribute(
      "aria-expanded",
      btn.getAttribute("aria-expanded") === "false" ? "true" : "false"
    );
  });
//   btn.addEventListener("mouseover", function (e) {
//     const dropdownIndex = e.currentTarget.dataset.dropdown;
//     const dropdownElement = document.getElementById(dropdownIndex);

//     dropdownElement.classList.toggle("active");
    
//     e.stopPropagation();
//     btn.setAttribute("aria-expanded", "true");
//   });
//   btn.addEventListener("mouseleave", function (e) {
//     const dropdownIndex = e.currentTarget.dataset.dropdown;
//     const dropdownElement = document.getElementById(dropdownIndex);

//     dropdownElement.classList.toggle("active");
  
//     drop.classList.remove("active");
//     e.stopPropagation();
//     btn.setAttribute("aria-expanded", "false");
//   });
});

// close dropdown menu when the dropdown links are clicked
links.forEach((link) =>
  link.addEventListener("click", () => {
    closeDropdownMenu();
    setAriaExpandedFalse();
    toggleHamburger();
  })
);

// close dropdown menu when you click on the document body
document.documentElement.addEventListener("click", () => {
  closeDropdownMenu();
  setAriaExpandedFalse();
});

// close dropdown when the escape key is pressed
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") {
    closeDropdownMenu();
    setAriaExpandedFalse();
  }
});

// toggle hamburger menu
if(hamburgerBtn) hamburgerBtn.addEventListener("click", toggleHamburger);
