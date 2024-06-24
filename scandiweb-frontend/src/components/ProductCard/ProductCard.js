import React from "react";
import "./ProductCard.css";
import emptyCart from "../../images/emptycart.svg";

const ProductCard = ({ product, addToCart }) => {
  let gallery = [];

  try {
    gallery = JSON.parse(product.gallery);
  } catch (error) {
    console.error("Failed to parse gallery JSON:", product.gallery);
  }

  if (!product || !gallery.length) {
    console.error("Gallery data is missing for product:", product);
    return <div>Product data is not available</div>;
  }

  return (
    <div className="product-card">
      <img src={gallery[0]} alt={product.name} className="product-image" />
      <h2 className="product-name">{product.name}</h2>
      <p className="product-price">
        {product.prices[0].currency_symbol}
        {product.prices[0].amount}
      </p>
      {product.in_stock ? (
        <button onClick={() => addToCart(product)} className="add-to-cart">
          <img src={emptyCart} alt="Add to cart" />
        </button>
      ) : (
        <div className="out-of-stock">Out Of Stock</div>
      )}
    </div>
  );
};

export default ProductCard;
