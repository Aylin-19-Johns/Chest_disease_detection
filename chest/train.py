# Install required packages
# !pip install tensorflow matplotlib

# Import necessary libraries
import tensorflow as tf
from tensorflow.keras.preprocessing.image import ImageDataGenerator
from tensorflow.keras.applications import VGG16
from tensorflow.keras import layers, models, optimizers

# Load your pre-trained model
model_path = 'path/to/your/model.hdf5'
loaded_model = tf.keras.models.load_model(model_path)

# Display model summary to understand its architecture
loaded_model.summary()

# Load your dataset and perform data augmentation
# Example assumes a directory structure with subdirectories for each class
train_datagen = ImageDataGenerator(
    rescale=1./255,
    rotation_range=20,
    width_shift_range=0.2,
    height_shift_range=0.2,
    shear_range=0.2,
    zoom_range=0.2,
    horizontal_flip=True,
    fill_mode='nearest'
)

# Adjust batch size and target size based on your dataset
train_generator = train_datagen.flow_from_directory(
    'path/to/your/train_data_directory',
    target_size=(224, 224),
    batch_size=32,
    class_mode='categorical'
)

# Adjust class weights to handle class imbalance
class_weights = {0: 1.0, 1: 1.0, 2: 1.0, 3: 1.0, 4: 1.5}  # Adjust weights accordingly

# Compile the model with a weighted loss function
loaded_model.compile(
    loss='categorical_crossentropy',
    optimizer=optimizers.Adam(),
    metrics=['accuracy']
)

# Train the model with balanced data and weighted loss
history = loaded_model.fit(
    train_generator,
    epochs=10,  # Adjust as needed
    class_weight=class_weights
)

# Evaluate the model on your test set
# Example assumes a similar directory structure for the test set
test_datagen = ImageDataGenerator(rescale=1./255)
test_generator = test_datagen.flow_from_directory(
    'path/to/your/test_data_directory',
    target_size=(224, 224),
    batch_size=32,
    class_mode='categorical'
)

test_loss, test_accuracy = loaded_model.evaluate(test_generator)

print(f'Test Accuracy: {test_accuracy}')

# Save the optimized model
optimized_model_path = 'path/to/save/optimized_model.hdf5'
loaded_model.save(optimized_model_path)
