import pandas as pd
from sklearn import tree, preprocessing
from sklearn.model_selection import train_test_split


#import des données
df=pd.read_csv('all.csv')
tempdata=df.drop(df.iloc[:, 0:2], axis=1)
tempdata=tempdata.drop(tempdata.iloc[:, 2:3], axis=1)
tempdata=tempdata.drop(tempdata.iloc[:, 3:4], axis=1)

#normalisation des données
temp = tempdata.values
min_max_scaler = preprocessing.MinMaxScaler()
temp_scaled = min_max_scaler.fit_transform(temp)
df = pd.DataFrame(temp_scaled)


y = df.iloc[:, 1]
data = df.drop(df.columns[1], axis=1)
X = data

#Séparation du jeu de données
X_train, X_test, y_train, y_test = train_test_split(X, y,shuffle=True)

clf = tree.DecisionTreeRegressor(max_depth=40)
clf = clf.fit(X_train, y_train)

def prediction(year, mileage, tax, mpg, engineSize):
    v = [[year, mileage, tax, mpg, engineSize]]
    coef = clf.predict(v)
    print(coef*(24000 - 8000) + 8000)

prediction(2017, 15735, 150, 55.4, 1.4)