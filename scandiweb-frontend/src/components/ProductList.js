import React from "react";
import { useQuery, gql } from "@apollo/client";

const GET_PRODUCTS = gql`
  query GetProducts {
    products {
      id
      name
      in_stock
      description
      category_id
      brand
      attributes {
        id
        attribute_name
        attribute_value
      }
      prices {
        id
        amount
        currency_label
        currency_symbol
      }
    }
  }
`;

const ProductList = () => {
  const { loading, error, data } = useQuery(GET_PRODUCTS);

  if (loading) return <p>Loading...</p>;
  if (error) return <p>Error :(</p>;

  return (
    <div>
      {data.products.map((product) => (
        <div key={product.id}>
          <h2>{product.name}</h2>
          <p>{product.description}</p>
          <p>{product.in_stock ? "In Stock" : "Out of Stock"}</p>
          <p>Brand: {product.brand}</p>
          <p>
            Price: {product.prices[0].currency_symbol}
            {product.prices[0].amount}
          </p>
        </div>
      ))}
    </div>
  );
};

export default ProductList;
