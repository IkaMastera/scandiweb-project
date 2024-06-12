import React from "react";
import "./Header.css";

const Header = ({ cartItems }) => {
  return (
    <header className="header">
      <div className="nav">
        <a href="#">Women</a>
        <a href="#">Men</a>
        <a href="#">Kids</a>
      </div>
      <div className="cart">
        <div>Cart: {cartItems.length} items</div>
      </div>
    </header>
  );
};

export default Header;
