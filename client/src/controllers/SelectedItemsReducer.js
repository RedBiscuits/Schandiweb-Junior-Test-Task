const initialState = []

export default function reducer (state = initialState , action){
    switch(action.type)
    {
        case "ADD_PRODUCT":
            return [...state,{
                sku: action.payload
            }
        ]
        case "REMOVE_PRODUCT":
            return state.filter((product) => product.sku !== action.payload )
        default:
            return state;
    }
        
}

export const addProduct = (sku) => ({
    type: "ADD_PRODUCT",
    payload: sku,
  });
  
  export const removeProduct = (sku) => ({
    type: "REMOVE_PRODUCT",
    payload: sku,
  });
  